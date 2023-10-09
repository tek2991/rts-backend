<?php

namespace App\Http\Controllers\Client;

use App\Actions\Functions\ParseSubscriptionDataFromSession;
use App\Models\Gst;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PublicSubscriptionController extends Controller
{
    public function parse()
    {
        $subscription_data = session('subscription_data');
        $package = Package::find($subscription_data['package_id']);
        $coupon = $subscription_data['coupon_id'] ? Coupon::find($subscription_data['coupon_id']) : false;

        $sgst = Gst::where('name', 'SGST')->first()->rate;
        $cgst = Gst::where('name', 'CGST')->first()->rate;
        $tax_rate = $sgst + $cgst;

        $started_at = now();
        $expires_at = clone $started_at;
        $expires_at->addDays($package->duration_in_days);

        $discount_amount = $coupon ? $package->price * $coupon->discount_percentage / 100 : 0;
        $gross_amount = $package->price - $discount_amount;
        $tax = $gross_amount * ($tax_rate / (100 + $tax_rate));
        $net_amount = $gross_amount - $tax;

        return [
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!session()->has('subscription_data')) {
            return abort(404, 'Package not found.');
        }
        $data = $this->parse();
        $package = $data['package'];
        $coupon = $data['coupon'];
        $discount_amount = $data['discount_amount'];
        $gross_amount = $data['gross_amount'];
        $tax = $data['tax'];
        $tax_rate = $data['tax_rate'];
        $net_amount = $data['net_amount'];

        return view('client.subscription.public.create', compact('package', 'coupon', 'discount_amount', 'gross_amount', 'tax', 'tax_rate', 'net_amount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        $payment = $subscription->payment;
        return view('client.subscription.show', compact('subscription', 'payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
