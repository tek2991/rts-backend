<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PaymentShow extends Component
{
    public $payment;
    public $subscription;

    public function mount($payment)
    {
        $this->payment = $payment;
        $this->subscription = $payment->subscription;
    }

    public function recheckPayment()
    {


        if ($this->payment->recheck()) {
            $this->payment = $this->payment->fresh();
            $this->subscription = $this->payment->subscription;

            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'success',
                'message' => 'Payment recheck success.',
            ]);
        } else {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Payment recheck failed.',
            ]);
            return;
        }
    }

    public function render()
    {
        return view('livewire.payment-show');
    }
}
