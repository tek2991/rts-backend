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
        // If no subscriptions found then redirect to expired page
        if (Auth::user()->subscriptions->count() == 0) {
            return redirect()->route('client.subscription.expired');
        }

        return view('client.subscription.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!session()->has('subscription_data')) {
            return abort(404, 'Package not found.');
        }
        $data = ParseSubscriptionDataFromSession::parse();
        $package = $data['package'];
        $coupon = $data['coupon'];
        $discount_amount = $data['discount_amount'];
        $gross_amount = $data['gross_amount'];
        $tax = $data['tax'];
        $tax_rate = $data['tax_rate'];
        $net_amount = $data['net_amount'];

        return view('client.subscription.create', compact('package', 'coupon', 'discount_amount', 'gross_amount', 'tax', 'tax_rate', 'net_amount'));
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
