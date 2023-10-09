<?php

namespace App\Http\Livewire\Client;

use App\Models\Coupon;
use App\Models\Gst;
use Livewire\Component;

class CalculateSubscriptionCost extends Component
{
    public $package;
    public $coupons = [];
    public $coupon = false;
    public $cgst;
    public $sgst;
    public $is_public = false;

    public $discount_amount = 0;
    public $cost;
    public $coupon_code = '';
    public $net_cost;
    public $tax;

    public function mount($package, $is_public = false)
    {
        $this->is_public = $is_public;
        $this->package = $package;
        $this->coupons = Coupon::where('is_active', true)->get();
        $this->sgst = Gst::where('name', 'SGST')->first()->rate;
        $this->cgst = Gst::where('name', 'CGST')->first()->rate;
        $this->calculateCost();
    }

    public function calculateCost()
    {
        $this->cost = $this->package->price;

        if ($this->coupon) {
            $this->cost = $this->cost - ($this->cost * $this->coupon->discount_percentage / 100);
            $this->discount_amount = $this->package->price - $this->cost;
        }

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
        $tax = $this->cost * ($tax_rate / (100 + $tax_rate));
        $this->tax = round($tax, 2);
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
        if ($coupon) {
            if ($coupon->isExpired()) {
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

    public function applySelectedCoupon($code)
    {
        $this->coupon_code = $code;
        $this->calculateSubscriptionCost();
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
        $data = [
            'package_id' => $this->package->id,
            'coupon_id' => $this->coupon ? $this->coupon->id : null,
        ];

        // Save the data to session
        session()->put('subscription_data', $data);

        if ($this->is_public) {
            // Redirect to public payment page
            return redirect()->route('public.subscription.create');
        }
        // Redirect to payment page
        return redirect()->route('client.subscription.create');
    }

    public function render()
    {
        return view('livewire.client.calculate-subscription-cost');
    }
}
