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
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!session()->has('subscription_data')) {
            return abort(404, 'Package not found.');
        }

        $payment_gateway = $request->gateway;
        if($payment_gateway != 'instamojo' && $payment_gateway != 'phonepe' && $payment_gateway != 'razorpay') {
            $payment_gateway = config('services.payment_gateway.default');
        }


        return view('client.subscription.public.create', compact('payment_gateway'));
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
