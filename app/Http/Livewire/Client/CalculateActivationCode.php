<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;
use App\Models\Subscription;
use App\Models\ActivationCode;

class CalculateActivationCode extends Component
{
    public $activationCode;
    public $price;
    public $duration_in_days;

    public $activation_code;

    public function mount()
    {
        $this->activationCode = false;
    }

    public function applyActivationCode()
    {
        $activationCode = ActivationCode::where('code', $this->activation_code)->first() ?? false;

        if(!$activationCode) {
            $this->addError('activation_code', 'Invalid activation code.');
            return;
        }

        if(!$activationCode->isValid()) {
            $this->addError('activation_code', 'Activation code is invalid.');
            return;
        }

        $this->activationCode = $activationCode;
        $this->price = $activationCode->price;
        $this->duration_in_days = $activationCode->duration_in_days;
    }

    public function removeActivationCode()
    {
        $this->activationCode = false;
        $this->price = null;
        $this->duration_in_days = null;
    }

    public function activate()
    {
        $activationCode = ActivationCode::where('code', $this->activation_code)->first() ?? false;
        if(!$activationCode) {
            $this->addError('activation_code', 'Invalid activation code.');
            return;
        }

        if(!$activationCode->isValid()) {
            $this->addError('activation_code', 'Activation code is invalid.');
            return;
        }

        $user = auth()->user();
        $started_at = $user->subscribedUpto() ? $user->subscribedUpto()->addDay() : now();
        $expires_at = clone $started_at;
        $expires_at->addDays($activationCode->duration_in_days);

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'activation_code_id' => $activationCode->id,
            'started_at' => $started_at,
            'expires_at' => $expires_at,
            'payment_method' => 'cash',
            'gross_amount' => $activationCode->price,
            'discount_amount' => 0,
            'net_amount' => $activationCode->price,
            'status' => 'paid',
        ]);


        return redirect()->route('client.subscription.show', $subscription);
    }

    public function render()
    {
        return view('livewire.client.calculate-activation-code');
    }
}
