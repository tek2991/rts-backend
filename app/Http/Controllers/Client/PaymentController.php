<?php

namespace App\Http\Controllers\Client;

use App\Models\Gst;
use App\Models\Coupon;
use App\Models\Package;
use Instamojo\Instamojo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Payment as PaymentModel;
use App\Actions\Functions\ParseSubscriptionDataFromSession;

class PaymentController extends Controller
{
    public function pay()
    {
        if (!session()->has('subscription_data')) {
            return abort(404, 'Package not found.');
        }

        $data = ParseSubscriptionDataFromSession::parse();
        session()->forget('subscription_data');

        $user = $data['user'];
        $package = $data['package'];
        $coupon = $data['coupon'];
        $discount_amount = $data['discount_amount'];
        $gross_amount = $data['gross_amount'];
        $tax = $data['tax'];
        $net_amount = $data['net_amount'];
        $started_at = $data['started_at'];
        $expires_at = $data['expires_at'];

        $api = $this->createAPI();

        try {
            $uuid = (string) Str::uuid();
            $arr = array(
                "purpose" => $uuid,
                "amount" => $data['gross_amount'],
                // "currency" => "INR", // Only INR is supported
                "send_email" => false,
                "email" => $user->email,
                "redirect_url" => route('client.payment.success'),
                "buyer_name" => $user->name,
                // "webhook" => route('client.payment.webhook'),
                "send_sms" => false,
                "phone" => substr($user->mobile_number, -10), // 10 digit phone number
                "allow_repeated_payments" => false
            );

            if (config('services.instamojo.enable_webhook')) {
                $arr['webhook'] = route('instamojo.payment.webhook');
            }

            $response = $api->createPaymentRequest($arr);

            if (array_key_exists('longurl', $response)) {
                $payment = $user->payments()->create([
                    'payment_id' => null,
                    'payment_request_id' => $response['id'],
                    'payment_status' => $response['status'],
                    'currency' => "INR",
                    'amount' => $response['amount'],
                    'fees' => null,
                    'buyer_name' => $response['buyer_name'],
                    'buyer_email' => $response['email'],
                    'buyer_phone' => $response['phone'],
                    'purpose' => $response['purpose'],
                    'shorturl' => $response['shorturl'],
                    'longurl' => $response['longurl'],
                    'mac' => null,
                ]);

                $user->subscriptions()->create([
                    'package_id' => $package->id,
                    'package_name' => $package->name,
                    'coupon_id' => $coupon ? $coupon->id : null,
                    'coupon_code' => $coupon ? $coupon->code : null,
                    'coupon_promoter_name' => $coupon ? $coupon->promoter_name : null,
                    'plan_net_amount' => $package->price,
                    'plan_tax' => $tax,
                    'started_at' => $started_at,
                    'expires_at' => $expires_at,
                    'duration_in_days' => $package->duration_in_days,
                    'gross_price' => $gross_amount,
                    'discount_amount' => $discount_amount,
                    'net_amount' => $net_amount,
                    'tax' => $tax,
                    'price' => $gross_amount,
                    'payment_method' => 'online',
                    'payment_id' => $payment->id,
                    'status' => 'pending',
                ]);

                return redirect($response['longurl']);
            } else {
                return redirect()->route('client.subscription.index')->dangerBanner("Error while creating payment request.");
            }
        } catch (\Exception $e) {
            return redirect()->route('client.subscription.index')->dangerBanner($e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $api = $this->createAPI();

        $payment_id = $request->payment_id;
        $payment_request_id = $request->payment_request_id;

        try {
            $response = $api->getPaymentDetails($payment_id);

            // Check if payment_request_id is valid and is in database
            $payment = PaymentModel::where('payment_request_id', $payment_request_id)->firstOrFail();

            // Get payment details
            $response = $api->getPaymentDetails($payment_id);

            if (array_key_exists('status', $response)) {
                $payment->update([
                    'payment_id' => $response['id'],
                    'payment_status' => $response['status'] === true ? 'success' : 'failed',
                    'currency' => $response['currency'],
                    'amount' => $response['amount'],
                    'fees' => $response['fees'],
                    'taxes' => $response['total_taxes'],
                    'instrument_type' => $response['instrument_type'],
                    'billing_instrument' => $response['billing_instrument'],
                    'redirected' => true,
                ]);

                if ($response['status'] == true) {
                    $subscription = $payment->subscription;

                    $subscription->update([
                        'status' => 'paid',
                    ]);
                } else {
                    $payment->update([
                        'failure_reason' => $response['failure']['reason'],
                        'failure_message' => $response['failure']['message'],
                    ]);

                    $payment->subscription()->update([
                        'status' => 'failed',
                    ]);

                    return redirect()->route('client.subscription.index')->dangerBanner("Payment failed. Please contact support.");
                }

                return redirect()->route('client.apk.index')->banner("Payment successful. Thank you for subscribing.");
            } else {
                return redirect()->route('client.subscription.index')->dangerBanner("Payment failed. Please contact support.");
            }
        } catch (\Exception $e) {
            return redirect()->route('client.subscription.index')->dangerBanner($e->getMessage());
        }
    }

    public function webhook()
    {
        $data = $_POST;

        if ($this->verifyMAC($data)) {
            $purpose = $data['purpose'];

            // Check if payment_request_id is valid and is in database
            try {
                $payment = PaymentModel::where('purpose', $purpose)->firstOrFail();
                $api = $this->createAPI();
                $response = $api->getPaymentDetails($payment->payment_id);

                if (array_key_exists('status', $response)) {
                    $payment->update([
                        'payment_id' => $response['id'],
                        'payment_status' => $response['status'] === true ? 'success' : 'failed',
                        'currency' => $response['currency'],
                        'amount' => $response['amount'],
                        'fees' => $response['fees'],
                        'taxes' => $response['total_taxes'],
                        'instrument_type' => $response['instrument_type'],
                        'billing_instrument' => $response['billing_instrument'],
                        'redirected' => true,
                    ]);

                    if ($response['status'] === true) {
                        $payment->update([
                            'failure_reason' => $response['failure']['reason'],
                            'failure_message' => $response['failure']['message'],
                        ]);

                        $payment->subscription()->update([
                            'status' => 'failed',
                        ]);
                    }
                }

                if ($data['status'] == "Credit") {
                    $payment->update([
                        'webhook_payment_id' => $data['payment_id'],
                        'mac' => $data['mac'],
                        'webhook_verified' => true,
                    ]);

                    $payment->subscription()->update([
                        'status' => 'paid',
                    ]);
                } else {
                    $payment->update([
                        'payment_status' => 'failed',
                        'mac' => $data['mac'],
                        'webhook_verified' => true,
                    ]);

                    $payment->subscription()->update([
                        'status' => 'failed',
                    ]);
                }
                return response()->json(['success' => true], 200);
            } catch (\Exception $e) {
                // Send an email to yourself informing you of invalid webhook call

                // Return error message
                return response()->json([
                    'error' => $e->getMessage() . ' - Failed',
                    'trace' => $e->getTraceAsString()
                ], 400);
            }
        } else {
            // Send an email to yourself informing you of invalid webhook call


            // Return a 400 response to caller
            return response()->json(['error' => 'Invalid webhook call (MAC)'], 400);
        }
    }

    public function verifyMAC($data)
    {
        $mac_provided = $data['mac'];  // Get the MAC from the POST data
        unset($data['mac']);  // Remove the MAC key from the data.
        $ver = explode('.', phpversion());
        $major = (int) $ver[0];
        $minor = (int) $ver[1];
        if ($major >= 5 and $minor >= 4) {
            ksort($data, SORT_STRING | SORT_FLAG_CASE);
        } else {
            uksort($data, 'strcasecmp');
        }
        // You can get the 'salt' from Instamojo's developers page(make sure to log in first): https://www.instamojo.com/developers
        // Pass the 'salt' without <>
        $mac_calculated = hash_hmac("sha1", implode("|", $data), config('services.instamojo.private_salt'));
        if ($mac_provided == $mac_calculated) {
            return true;
        } else {
            return false;
        }
    }

    public function createAPI()
    {
        if (config('services.instamojo.sandbox')) {
            $api = Instamojo::init(
                config('services.instamojo.auth_type'),
                [
                    "client_id" => config('services.instamojo.client_id'),
                    "client_secret" => config('services.instamojo.client_secret'),
                ],
                True
            );
        } else {
            $api = Instamojo::init(
                config('services.instamojo.auth_type'),
                [
                    "client_id" => config('services.instamojo.client_id'),
                    "client_secret" => config('services.instamojo.client_secret'),
                ],
                False
            );
        }

        return $api;
    }
}
