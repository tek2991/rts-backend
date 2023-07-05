<?php

namespace App\Http\Livewire\Client;

use App\Models\Coupon;
use Livewire\Component;

class CalculateSubscriptionCost extends Component
{
    public $package;
    public $coupon = false;
    public $discount_amount = 0;
    public $cost;
    public $coupon_code = '';

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
            $this->discount_amount = $this->package->price - $this->cost;
        }
    }

    // Auto cap the coupon code to uppercase
    public function updatedCouponCode($value)
    {
        $this->coupon_code = $this->toUpper($value);
    }

    public function toUpper($value)
    {
        return strtoupper($value);
    }

    public function calculateSubscriptionCost()
    {
        $coupon = Coupon::where('code', $this->toUpper($this->coupon_code))->first() ?? false;
        if($coupon) {
            if($coupon->isExpired()) {
                $this->addError('coupon_code', 'Coupon code is expired.');
                return;
            }
            $this->coupon = $coupon;
            // Remove coupon_code from error bag
            $this->resetErrorBag('coupon_code');
        } else {
            $this->addError('coupon_code', 'Invalid coupon code.');
        }


        if ($this->coupon) {
            $this->calculateCost();
        } else {
            $this->addError('coupon_code', 'Invalid coupon code.');
        }
    }

    public function applyCoupon()
    {
        $this->calculateSubscriptionCost();
    }

    public function removeCoupon()
    {
        $this->coupon_code = '';
        $this->coupon = false;
        $this->calculateCost();
    }

    public function payNow()
    {

    }

    public function render()
    {
        return view('livewire.client.calculate-subscription-cost');
    }
}
