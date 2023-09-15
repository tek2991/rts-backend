<?php

namespace App\Http\Controllers\Client;

use App\Models\Gst;
use App\Models\Coupon;
use App\Models\Package;
use Instamojo\Instamojo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function pay()
    {
        // Check subscription_data in session
        if (!session()->has('subscription_data')) {
            return abort(404, 'Package not found.');
        }
        
        $subscription_data = session('subscription_data');
        $package = Package::find($subscription_data['package_id']);
        $coupon = $subscription_data['coupon_id'] ? Coupon::find($subscription_data['coupon_id']) : false;

        $sgst = Gst::where('name', 'SGST')->first()->rate;
        $cgst = Gst::where('name', 'CGST')->first()->rate;
        $tax_rate = $sgst + $cgst;

        $user = auth()->user();
        $started_at = $user->subscribedUpto() ? Carbon::createFromFormat('Y-m-d', $user->subscribedUpto())->addDay() : now();
        $expires_at = clone $started_at;
        $expires_at->addDays($package->duration_in_days);

        $discount_amount = $coupon ? $package->price * $coupon->discount_percentage / 100 : 0;
        $gross_amount = $package->price - $discount_amount;
        $tax = $gross_amount * ($tax_rate / (100 + $tax_rate));
        $net_amount = $gross_amount - $tax;

        if (config('services.instamojo.sandbox')) {
            $api = Instamojo::init(
                config('services.instamojo.auth_type'),
                [
                    "client_id" => config('services.instamojo.client_id'),
                    "client_secret" => config('services.instamojo.client_secret'),
                ],
                True
            );
        } else {
            $api = Instamojo::init(
                config('services.instamojo.auth_type'),
                [
                    "client_id" => config('services.instamojo.client_id'),
                    "client_secret" => config('services.instamojo.client_secret'),
                ],
                False
            );
        }

        try {
            $response = $api->paymentRequestCreate(array(
                "purpose" => "Subscription",
                "amount" => $gross_amount,
                "buyer_name" => $user->name,
                "send_email" => true,
                "email" => $user->email,
                "redirect_url" => route('client.subscription.payment.success'),
                "webhook" => route('client.subscription.payment.webhook'),
                "send_sms" => true,
                "phone" => $user->mobile_number,
                "allow_repeated_payments" => false  
            ));

            return redirect($response['longurl']);
        } catch (\Exception $e) {
            return redirect()->route('client.subscription.index')->with('error', $e->getMessage());
        }
    }
}
