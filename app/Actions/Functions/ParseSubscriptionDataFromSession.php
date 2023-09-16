<?php

namespace App\Actions\Functions;

use App\Models\Gst;
use App\Models\Coupon;
use App\Models\Package;
use Livewire\Component;
use Illuminate\Support\Carbon;

class ParseSubscriptionDataFromSession
{
    public static function parse()
    {
        $subscription_data = session('subscription_data');
        $package = Package::find($subscription_data['package_id']);
        $coupon = $subscription_data['coupon_id'] ? Coupon::find($subscription_data['coupon_id']) : false;

        $sgst = Gst::where('name', 'SGST')->first()->rate;
        $cgst = Gst::where('name', 'CGST')->first()->rate;
        $tax_rate = $sgst + $cgst;

        $user = auth()->user();
        $started_at = $user->subscribedUpto() ? Carbon::createFromFormat('Y-m-d', $user->subscribedUpto())->addDay() : now();
        $expires_at = clone $started_at;
        $expires_at->addDays($package->duration_in_days);

        $discount_amount = $coupon ? $package->price * $coupon->discount_percentage / 100 : 0;
        $gross_amount = $package->price - $discount_amount;
        $tax = $gross_amount * ($tax_rate / (100 + $tax_rate));
        $net_amount = $gross_amount - $tax;

        return [
            'user' => $user,
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
}
