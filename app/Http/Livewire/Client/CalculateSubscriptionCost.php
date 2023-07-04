<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

class CalculateSubscriptionCost extends Component
{
    public $package;
    public $coupon = null;
    public $cost;

    public function mount($package)
    {
        $this->package = $package;
        $this->calculateCost();
    }

    public function calculateCost()
    {
        $this->cost = $this->package->price;

        if ($this->coupon) {
            $this->cost = $this->cost - ($this->cost * $this->coupon->discount_percentage / 100);
        }
    }

    public function render()
    {
        return view('livewire.client.calculate-subscription-cost');
    }
}
