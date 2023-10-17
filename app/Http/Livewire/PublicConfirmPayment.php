<?php

namespace App\Http\Livewire;

use App\Models\Gst;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\User;
use Livewire\Component;

class PublicConfirmPayment extends Component
{
    public $data = null;
    public $package = null;
    public $coupon = null;
    public $discount_amount = null;
    public $gross_amount = null;
    public $tax = null;
    public $tax_rate = null;
    public $net_amount = null;

    public $payment_gateway;
    public $payment_route;

    public $name;
    public $email;
    public $mobile_number;
    public $acknowledgement;


    public function mount($payment_gateway)
    {
        $this->payment_gateway = $payment_gateway;
        $this->data = $this->parse();
        $this->package = $this->data['package'];
        $this->coupon = $this->data['coupon'];
        $this->discount_amount = $this->data['discount_amount'];
        $this->gross_amount = $this->data['gross_amount'];
        $this->tax = $this->data['tax'];
        $this->tax_rate = $this->data['tax_rate'];
        $this->net_amount = $this->data['net_amount'];
    }

    public function makePaymentRoute()
    {
        $this->payment_route = $this->payment_gateway == 'instamojo' ? route('client.instamojo.payment.pay') : route('client.phonepe.payment.pay');
    }

    public function parse()
    {
        $subscription_data = session('subscription_data');
        $package = Package::find($subscription_data['package_id']);
        $coupon = $subscription_data['coupon_id'] ? Coupon::find($subscription_data['coupon_id']) : false;

        $sgst = Gst::where('name', 'SGST')->first()->rate;
        $cgst = Gst::where('name', 'CGST')->first()->rate;
        $tax_rate = $sgst + $cgst;

        $started_at = now();
        $expires_at = clone $started_at;
        $expires_at->addDays($package->duration_in_days);

        $discount_amount = $coupon ? $package->price * $coupon->discount_percentage / 100 : 0;
        $gross_amount = $package->price - $discount_amount;
        $tax = $gross_amount * ($tax_rate / (100 + $tax_rate));
        $net_amount = $gross_amount - $tax;

        return [
            'package' => $package,
            'coupon' => $coupon,
            'discount_amount' => $discount_amount,
            'gross_amount' => $gross_amount,
            'tax' => $tax,
            'tax_rate' => $tax_rate,
            'net_amount' => $net_amount,
            'started_at' => $started_at,
            'expires_at' => $expires_at,
        ];
    }

    public function randPass()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $special = '!@#$%^&*()_+{}:"<>?\|[];\',./`~';
        
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        for ($i = 0; $i < 2; $i++) {
            $n = rand(0, strlen($special) - 1);
            $pass[] = $special[$n];
        }

        return implode($pass); //turn the array into a string
    }

    public function register()
    {
        // validate
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile_number' => 'required|digits:10|unique:users,mobile_number',
            'acknowledgement' => 'required|accepted',
        ]);

        $password = $this->randPass();

        // create user
        $user = User::create([
            'name' => $this->name,
            'email' => strtolower($this->email),
            'mobile_number' => $this->mobile_number,
            'password' => $password,
        ]);

        // assign client role to the user
        $user->assignRole('client');

        // send welcome email
        $user->sendWelcomeEmailWithPassword($password);

        // Login the user
        auth()->login($user);

        // Redirect to payment page
        return redirect($this->payment_route);
    }

    public function render()
    {
        return view('livewire.public-confirm-payment');
    }
}
