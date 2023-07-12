<?php

namespace App\Http\Controllers\Client;

use App\Models\Gst;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscriptionExpired()
    {
        if(Auth::user()->hasActiveSubscription()) {
            return redirect()->route('client.dashboard');
        }
        return view('client.subscription.expired');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.subscription.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check subscription_data in session
        if (session()->has('subscription_data')) {
            $package = Package::find(session('subscription_data.package_id'));
            $coupon = session('subscription_data.coupon_id') ? Coupon::find(session('subscription_data.coupon_id')) : false;
            if ($package) {
                if ($coupon) {
                    if ($coupon->isExpired()) {
                        session()->forget('subscription_data');
                        return redirect()->route('client.subscription.expired');
                    }
                }
            } else {
                session()->forget('subscription_data');
                return redirect()->route('client.subscription.expired');
            }
            $sgst = Gst::where('name', 'SGST')->first()->rate;
            $cgst = Gst::where('name', 'CGST')->first()->rate;
            $tax_rate = $sgst + $cgst;
            
            $discount_amount = $coupon ? $package->price * $coupon->discount_percentage / 100 : 0;
            $gross_amount = $package->price - $discount_amount;
            $tax = $gross_amount * ($tax_rate / (100 + $tax_rate));
            $net_amount = $gross_amount - $tax;
        } else {
            return abort(404, 'Package not found.');
        }

        return view('client.subscription.create', compact('package', 'coupon', 'discount_amount', 'gross_amount', 'tax', 'tax_rate', 'net_amount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check subscription_data in session
        if (!session()->has('subscription_data')) {
            return abort(404, 'Package not found.');
        }
        $subscription_data = session('subscription_data');
        $package = Package::find($subscription_data['package_id']);
        $coupon = $subscription_data['coupon_id'] ? Coupon::find($subscription_data['coupon_id']) : false;

        $sgst = Gst::where('name', 'SGST')->first()->rate;
        $cgst = Gst::where('name', 'CGST')->first()->rate;
        $tax_rate = $sgst + $cgst;

        $user = auth()->user();
        $started_at = $user->subscribedUpto() ? $user->subscribedUpto()->addDay() : now();
        $expires_at = clone $started_at;
        $expires_at->addDays($package->duration_in_days);

        $discount_amount = $coupon ? $package->price * $coupon->discount_percentage / 100 : 0;
        $gross_amount = $package->price - $discount_amount;
        $tax = $gross_amount * ($tax_rate / (100 + $tax_rate));
        $net_amount = $gross_amount - $tax;

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'package_name' => $package->name,
            'coupon_id' => $coupon ? $coupon->id : null,
            'coupon_code' => $coupon ? $coupon->code : null,
            'coupon_promoter_name' => $coupon ? $coupon->promoter_name : null,
            'plan_net_amount' => $package->price,
            'plan_tax' => $package->tax,
            'started_at' => $started_at,
            'expires_at' => $expires_at,
            'duration_in_days' => $package->duration_in_days,
            'gross_price' => $package->price,
            'discount_amount' => $discount_amount,
            'net_amount' => $net_amount,
            'tax' => $tax,
            'price' => $net_amount + $tax,
            'payment_method' => 'online',
            'status' => 'paid',
        ]);

        // Send notification to admin
        // $this->sendNotificationToAdmin($subscription);

        // Send notification to client
        // $this->sendNotificationToClient($subscription);

        // Remove subscription_data from session
        session()->forget('subscription_data');

        return redirect()->route('client.subscription.show', $subscription);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        return view('client.subscription.show', compact('subscription'));
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
