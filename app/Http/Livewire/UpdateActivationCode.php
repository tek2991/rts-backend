<?php

namespace App\Http\Livewire;

use App\Models\Gst;
use Livewire\Component;

class UpdateActivationCode extends Component
{
    public $cgst;
    public $sgst;
    public $activationCode;

    public $editable = true;

    public $state = [
        'code' => '',
        'duration' => 0,
        'net_amount' => 0,
        'tax' => 0,
        'price' => 0,
        'expires_at' => '',
    ];

    public function mount($activationCode)
    {
        $this->cgst = Gst::where('name', 'CGST')->first()->rate;
        $this->sgst = Gst::where('name', 'SGST')->first()->rate;
        $this->activationCode = $activationCode;

        $this->state['code'] = $activationCode->code;
        $this->state['duration'] = $activationCode->duration_in_days;
        $this->state['net_amount'] = $activationCode->net_amount;
        $this->state['tax'] = $activationCode->tax;
        $this->state['price'] = $activationCode->price;
        $this->state['expires_at'] = $activationCode->expires_at->format('Y-m-d');

        if ($activationCode->isUsed()) {
            $this->editable = false;
        }
    }

    // Updated net_amount

    public function updatedStateNetAmount()
    {
        $this->calcGst();
        $this->roundOff();
    }

    public function updatedStatePrice()
    {   
        $this->validate([
            'state.price' => 'required|integer|min:0',
        ]);
        $this->state['net_amount'] = $this->state['price'] / (1 + ($this->cgst + $this->sgst) / 100);
        $this->state['tax'] = $this->state['price'] - $this->state['net_amount'];
        $this->roundOff();
    }

    public function roundOff($decimal = 2)
    {
        $this->state['net_amount'] = round($this->state['net_amount'], $decimal);
        $this->state['tax'] = round($this->state['tax'], $decimal);
        $this->state['price'] = round($this->state['price'], $decimal);
    }

    public function calcGst()
    {
        $this->validate([
            'state.net_amount' => 'required|integer|min:0',
        ]);

        $this->state['tax'] = $this->state['net_amount'] * ($this->cgst + $this->sgst) / 100;
        $this->state['price'] = $this->state['net_amount'] + $this->state['tax'];
    }

    public function save()
    {
        if(!$this->editable) {
            return;
        }

        $this->validate([
            'state.code' => 'required|string|unique:activation_codes,code,' . $this->activationCode->id,
            'state.duration' => 'required|integer|min:1',
            'state.net_amount' => 'required|numeric|min:0',
            'state.tax' => 'required|numeric|min:0',
            'state.price' => 'required|numeric|min:0',
            'state.expires_at' => 'required|date|after:today',
        ]);

        $this->activationCode->update([
            'code' => $this->state['code'],
            'duration_in_days' => $this->state['duration'],
            'net_amount' => $this->state['net_amount'],
            'tax' => $this->state['tax'],
            'price' => $this->state['price'],
            'expires_at' => $this->state['expires_at'],
        ]);

        // Save to session
        session()->flash('flash.banner', 'Activation code updated successfully: ' . $this->state['code']);

        // Redirect to index
        return redirect()->route('activation-code.index');
    }

    public function render()
    {
        return view('livewire.update-activation-code');
    }
}
