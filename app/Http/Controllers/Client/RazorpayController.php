<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Functions\ParseSubscriptionDataFromSession;
use App\Models\Payment;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    public function createApi()
    {
        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        return new Api($key, $secret);
    }

    public function success(Request $request)
    {
        try {
            $api = $this->createApi();

            // Check if order id is valid
            if (!$request->has('razorpay_order_id')) {
                return redirect()->route('client.subscription.index')->dangerBanner('Invalid order id.');
            }

            // Check if order id exists in database
            $order = Payment::where('razorpay_order_id', $request->razorpay_order_id)->first();

            if (!$order) {
                return redirect()->route('client.subscription.index')->dangerBanner('Order ID not found.');
            }

            $api->utility->verifyPaymentSignature(array(
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ));

            $order = $api->order->fetch($request->razorpay_order_id);



            // If order status is paid
            if ($order->status == 'paid') {
                $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)->first();

                $payment->update([
                    'payment_status' => 'success',

                    'redirected' => true,

                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                ]);

                $subscription = $payment->subscription;

                $subscription->update([
                    'status' => 'paid'
                ]);
                return redirect()->route('client.subscription.index')->banner('Payment successful.');
            } else {
                return redirect()->route('client.subscription.index')->dangerBanner('Payment failed.');
            }
        } catch (\Exception $e) {
            return redirect()->route('client.subscription.index')->dangerBanner($e->getMessage());
        }
    }

    public function webhook(Request $request)
    {
        $data = $request->all();
        $webhookSignature = $request->header('X-Razorpay-Signature');

        $api = $this->createApi();
        $webhook_secret = config('services.razorpay.webhook_secret');

        try {
            $api->utility->verifyWebhookSignature($request->getContent(), $webhookSignature, $webhook_secret);
            // If webhook is for payment captured
            if ($data['event'] == 'payment.captured') {
                $order_id = $data['payload']['payment']['entity']['order_id'];

                $payment = Payment::where('razorpay_order_id', $order_id)->first();

                $order = $api->order->fetch($order_id);

                if ($order->status == 'paid') {
                    $payment->update([
                        'payment_status' => 'success',

                        'razorpay_payment_id' => $data['payload']['payment']['entity']['id'],
                        'razorpay_signature' => $webhookSignature,
                    ]);

                    $subscription = $payment->subscription;

                    $subscription->update([
                        'status' => 'paid'
                    ]);

                    return response()->json([
                        'success' => 'Payment successful.'
                    ], 200);
                } else {
                    return response()->json([
                        'error' => 'Payment failed.'
                    ], 400);
                }
            }

            // If webhook is for payment failed
            if ($data['event'] == 'payment.failed') {
                $order_id = $data['payload']['payment']['entity']['order_id'];

                $payment = Payment::where('razorpay_order_id', $order_id)->first();

                $payment->update([
                    'payment_status' => 'failed',

                    'razorpay_payment_id' => $data['payload']['payment']['entity']['id'],
                    'razorpay_signature' => $webhookSignature,

                    'failure_reason' => $data['payload']['payment']['entity']['error_code'],
                    'failure_message' => $data['payload']['payment']['entity']['error_description'],
                ]);

                return response()->json([
                    'error' => 'Payment failed.'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
