<?php

namespace App\Http\Livewire\Client;

use App\Models\Gst;
use Livewire\Component;
use App\Models\Subscription;
use App\Models\ActivationCode;
use Illuminate\Support\Carbon;

class CalculateActivationCode extends Component
{
    public $activationCode;
    public $price;
    public $duration_in_days;

    public $cgst;
    public $sgst;
    public $cost;
    public $net_cost;
    public $tax;

    public $activation_code;

    public function mount()
    {
        $this->activationCode = false;
        $this->sgst = Gst::where('name', 'SGST')->first()->rate;
        $this->cgst = Gst::where('name', 'CGST')->first()->rate;
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


        $this->calculateTax();
        $this->calculateNetCost();
    }

    public function calculateNetCost()
    {
        $this->net_cost = $this->cost - $this->tax;
    }

    public function calculateTax()
    {
        $tax_rate = $this->sgst + $this->cgst;
        $this->cost = $this->price;
        $tax = $this->cost * ($tax_rate / (100 + $tax_rate));
        $this->tax = round($tax, 2);
    }

    public function removeActivationCode()
    {
        $this->activationCode = false;
        $this->price = null;
        $this->duration_in_days = null;
        $this->cost = null;
        $this->net_cost = null;
        $this->tax = null;
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
        $started_at = $user->subscribedUpto() ? $user->subscribedUpto()->addSecond() : now();
        $expires_at = clone $started_at;
        $expires_at->addDays($activationCode->duration_in_days);

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'activation_code_id' => $activationCode->id,
            'activation_code' => $activationCode->code,
            'plan_net_amount' => $activationCode->price,
            'plan_tax' => $activationCode->tax,
            'started_at' => $started_at,
            'expires_at' => $expires_at,
            'duration_in_days' => $activationCode->duration_in_days,
            'gross_price' => $activationCode->price,
            'discount_amount' => 0,
            'net_amount' => $this->net_cost,
            'tax' => $this->tax,
            'price' => $this->cost,
            'payment_method' => 'activation_code',
            'status' => 'paid',
        ]);

        $activationCode->update([
            'used_at' => now(),
        ]);

        session()->flash('flash.banner', 'Your subscription has been activated successfully.');

        return redirect()->route('client.apk.index');
    }

    public function render()
    {
        return view('livewire.client.calculate-activation-code');
    }
}
