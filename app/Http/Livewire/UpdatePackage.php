<?php

namespace App\Http\Livewire;

use App\Models\Gst;
use App\Models\Package;
use Livewire\Component;

class UpdatePackage extends Component
{
    public $cgst;
    public $sgst;
    public $package;

    public $state = [
        'name' => '',
        'duration' => 0,
        'net_amount' => 0,
        'tax' => 0,
        'price' => 0,
        'is_active' => true,
    ];

    public function mount($package)
    {
        $this->cgst = Gst::where('name', 'CGST')->first()->rate;
        $this->sgst = Gst::where('name', 'SGST')->first()->rate;
        $this->package = $package;

        $this->state['name'] = $package->name;
        $this->state['duration'] = $package->duration_in_days;
        $this->state['net_amount'] = $package->net_amount;
        $this->state['tax'] = $package->tax;
        $this->state['price'] = $package->price;
        $this->state['is_active'] = $package->is_active;
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
        $this->validate([
            'state.name' => 'required|string|max:255',
            'state.duration' => 'required|integer|min:1',
            'state.net_amount' => 'required|numeric|min:0',
            'state.tax' => 'required|numeric|min:0',
            'state.price' => 'required|numeric|min:0',
            'state.is_active' => 'required|boolean',
        ]);

        $this->package->update([
            'name' => $this->state['name'],
            'duration_in_days' => $this->state['duration'],
            'net_amount' => $this->state['net_amount'],
            'tax' => $this->state['tax'],
            'price' => $this->state['price'],
            'is_active' => $this->state['is_active'],
        ]);

        // Save to session
        session()->flash('flash.banner', 'Package updated successfully: ' . $this->state['name']);

        // Redirect to index
        return redirect()->route('package.index');
    }
    
    public function render()
    {
        return view('livewire.update-package');
    }
}
