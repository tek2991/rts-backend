<?php

namespace App\Http\Livewire\Client;

use Throwable;
use Razorpay\Api\Api;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\Payment;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Actions\Functions\ParseSubscriptionDataFromSession;

class Razorpay extends Component
{
    public $razorpay_key = null;
    public $session_data = null;

    public $razor_order_generated = false;
    public $razor_order_data = [];

    public function mount()
    {
        $this->razorpay_key = config('services.razorpay.key');
        $this->getSessionData();
    }

    public function createApi()
    {
        $id = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        return new Api($id, $secret);
    }

    public function getSessionData()
    {
        if (!session()->has('subscription_data')) {
            return abort(404, 'Package not found.');
        }
        $this->session_data = ParseSubscriptionDataFromSession::parse();
        $this->session_data['app_name'] = config('app.name');
        $this->session_data['logo'] = asset('logo.png');
        $this->session_data['callback_url'] = route('client.razorpay.payment.success');
    }

    public function createRazorpayOrder()
    {
        try {
            $receipt = (string) Str::uuid();

            $order_data = array(
                'receipt' => $receipt,
                'amount' => $this->session_data['gross_amount'] * 100,
                'currency' => 'INR',
            );

            $order = $this->createApi()->order->create($order_data);

            if ($order->status != 'created') {
                throw new \Exception("Error while creating payment request. status != created");
            }

            $this->razor_order_generated = true;

            $this->razor_order_data = [
                'id' => $order->id,
                'entity' => $order->entity,
                'amount' => $order->amount,
                'currency' => $order->currency,
                'receipt' => $order->receipt,
                'status' => $order->status,
                'created_at' => $order->created_at,
            ];

            $user = auth()->user();
            $package = Package::find($this->session_data['package']['id']);
            $coupon = $this->session_data['coupon'] ? Coupon::find($this->session_data['coupon']['id']) : false;

            $payment = Payment::create([
                'user_id' => $user->id,
                'payment_id' => null,
                'payment_request_id' => null,
                'payment_status' => 'pending',
                'currency' => "INR",
                'amount' => $this->session_data['gross_amount'],
                'fees' => null,
                'buyer_name' => $user->name,
                'buyer_email' => $user->email,
                'buyer_phone' => $user->mobile_number,
                'purpose' => null,
                'shorturl' => null,
                'longurl' => null,
                'mac' => null,
                // razorpay
                'gateway' => 'razorpay',
                'razorpay_order_id' => $order->id,
            ]);

            $user->subscriptions()->create([
                'package_id' => $package->id,
                'package_name' => $package->name,
                'coupon_id' => $coupon ? $coupon->id : null,
                'coupon_code' => $coupon ? $coupon->code : null,
                'coupon_promoter_name' => $coupon ? $coupon->promoter_name : null,
                'plan_net_amount' => $package->price,
                'plan_tax' => $this->session_data['tax'],
                'started_at' => $this->session_data['started_at'],
                'expires_at' => $this->session_data['expires_at'],
                'duration_in_days' => $package->duration_in_days,
                'gross_price' => $this->session_data['gross_amount'],
                'discount_amount' => $this->session_data['discount_amount'],
                'net_amount' => $this->session_data['net_amount'],
                'tax' => $this->session_data['tax'],
                'price' => $this->session_data['gross_amount'],
                'payment_method' => 'online',
                'payment_id' => $payment->id,
                'status' => 'pending',
            ]);

            session()->forget('subscription_data');

        } catch (Throwable $th) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.client.razorpay');
    }
}
