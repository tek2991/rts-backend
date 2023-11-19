<?php

namespace App\Http\Livewire\Client;

use Razorpay\Api\Api;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Actions\Functions\ParseSubscriptionDataFromSession;
use App\Models\Payment;
use Throwable;

class PaymentButton extends Component
{
    public $payment_gateway = '';
    public $payment_route = '';

    public function mount($payment_gateway)
    {
        $this->payment_gateway = $payment_gateway;
        $this->setPaymentRoute();
    }

    public function setPaymentRoute()
    {
        if ($this->payment_gateway == 'instamojo') {
            $this->payment_route = route('client.instamojo.payment.pay');
        } else if ($this->payment_gateway == 'phonepe') {
            $this->payment_route = route('client.phonepe.payment.pay');
        }
    }

    public function render()
    {
        return view('livewire.client.payment-button');
    }
}
