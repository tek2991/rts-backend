<?php

namespace App\Http\Controllers\Client;

use App\Models\Gst;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\Payment as PaymentModel;
use Instamojo\Instamojo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function pay()
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
        $started_at = $user->subscribedUpto() ? Carbon::createFromFormat('Y-m-d', $user->subscribedUpto())->addDay() : now();
        $expires_at = clone $started_at;
        $expires_at->addDays($package->duration_in_days);

        $discount_amount = $coupon ? $package->price * $coupon->discount_percentage / 100 : 0;
        $gross_amount = $package->price - $discount_amount;
        $tax = $gross_amount * ($tax_rate / (100 + $tax_rate));
        $net_amount = $gross_amount - $tax;

        $api = $this->createAPI();

        try {
            $uuid = (string) Str::uuid();
            $response = $api->createPaymentRequest(array(
                "purpose" => $uuid,
                "amount" => $gross_amount,
                // "currency" => "INR", // Only INR is supported
                "send_email" => false,
                "email" => $user->email,
                "redirect_url" => route('client.payment.success'),
                "buyer_name" => $user->name,
                // "webhook" => route('client.payment.webhook'),
                "send_sms" => false,
                "phone" => substr($user->mobile_number, -10), // 10 digit phone number
                "allow_repeated_payments" => false
            ));

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

                if ($response['status'] !== true) {
                    $payment->update([
                        'failure_reason' => $response['failure']['reason'],
                        'failure_message' => $response['failure']['message'],
                    ]);

                    $payment->subscription()->update([
                        'status' => 'failed',
                    ]);

                    return redirect()->route('client.subscription.index')->dangerBanner("Payment failed. Please contact support.");
                }

                return redirect()->route('client.subscription.index')->banner("Payment successful. Thank you for subscribing.");
            } else {
                return redirect()->route('client.subscription.index')->dangerBanner("Payment failed. Please contact support.");
            }
        } catch (\Exception $e) {
            return redirect()->route('client.subscription.index')->dangerBanner($e->getMessage());
        }
    }

    public function webhook(Request $request)
    {
        $data = $request->all();

        if ($this->verifyMAC($data)) {
            $payment_id = $data['payment_id'];
            $payment_request_id = $data['payment_request_id'];

            // Check if payment_request_id is valid and is in database
            $payment = PaymentModel::where('payment_request_id', $payment_request_id)->where('payment_id', $payment_id)->firstOrFail();

            if ($data['status'] == "Credit") {
                $payment->update([
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
        } else {
            // Send an email to yourself informing you of invalid webhook call


            // Return a 400 response to caller
            return response()->json(['error' => 'Invalid webhook call'], 400);
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
        $mac_calculated = hash_hmac("sha1", implode("|", $data), "<YOUR_SALT>");
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
