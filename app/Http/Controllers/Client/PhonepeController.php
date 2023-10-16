<?php

namespace App\Http\Controllers\Client;

use App\Models\Gst;
use App\Models\Coupon;
use App\Models\Package;
use Instamojo\Instamojo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Payment as PaymentModel;
use App\Actions\Functions\ParseSubscriptionDataFromSession;

class PhonepeController extends Controller
{
    public function encodeData($data)
    {
        $encoded = base64_encode(json_encode($data));
        return $encoded;
    }

    public function finalXheader($data)
    {
        $salt = config('services.phonepe.salt');
        $salt_index = config('services.phonepe.salt_index');
        $pay_endpoint = config('services.phonepe.pay_endpoint');


        $encoded = $this->encodeData($data);
        $str = $encoded . $pay_endpoint . $salt;
        $hash = hash('sha256', $str);
        $final_x_header = $hash . "###" . $salt_index;

        return $final_x_header;
    }

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

        try {
            $merchant_transaction_id = (string) Str::uuid();
            $merchant_user_id = $user->id . '_' . $user->mobile_number;

            $data = array(
                'merchantId' => config('services.phonepe.merchant_id'),
                'merchantTransactionId' => $merchant_transaction_id,
                'merchantUserId' => $merchant_user_id,
                'amount' => $gross_amount * 100,
                'redirectUrl' => route('client.phonepe.payment.success'),
                'redirectMode' => 'REDIRECT',
                'callbackUrl' => route('phonepe.payment.webhook'),
                'mobileNumber' => $user->mobile_number,
                'paymentInstrument' => array(
                    'type' => 'PAY_PAGE',
                ),
            );

            $encoded = $this->encodeData($data);
            $xheader = $this->finalXheader($data);

            $url = config('services.phonepe.production') ? config('services.phonepe.prod_url') : config('services.phonepe.preprod_url');
            $url .= config('services.phonepe.pay_endpoint');

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'request' => $encoded,
                ]),
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "accept: application/json",
                    "X-VERIFY: " . $xheader,
                ],
            ]);

            $response = json_decode(curl_exec($curl));
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                throw new \Exception("Error while creating payment request. err: $err");
            }

            if (!isset($response->success)) {
                throw new \Exception("Error while creating payment request. success not set");
            }

            if ($response->success != true) {
                throw new \Exception("Error while creating payment request. success != true");
            }

            if(!isset($response->data->instrumentResponse->redirectInfo->url)) {
                throw new \Exception("Error while creating payment request. paymentUrl not set");
            }

            if ($response->success == true) {
                $payment = $user->payments()->create([
                    'payment_id' => null,
                    'payment_request_id' => null,
                    'payment_status' => 'pending',
                    'currency' => "INR",
                    'amount' => $gross_amount,
                    'fees' => null,
                    'buyer_name' => $user->name,
                    'buyer_email' => $user->email,
                    'buyer_phone' => $user->mobile_number,
                    'purpose' => $package->name,
                    'shorturl' => null,
                    'longurl' => $response->data->instrumentResponse->redirectInfo->url,
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

                return redirect($response->data->instrumentResponse->redirectInfo->url);
            } else {
                return redirect()->route('client.subscription.index')->dangerBanner("Error while creating payment request.");
            }
        } catch (\Exception $e) {
            return redirect()->route('client.subscription.index')->dangerBanner($e->getMessage());
        }
    }

    public function success(Request $request)
    {
        dd($request->all());

        

        try {
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

                if ($response['status'] === true) {
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
            $payment_request_id = $data['payment_request_id'];

            // Check if payment_request_id is valid and is in database
            try {
                $response = $this->getLastPayment($payment_request_id);

                if (!$response) return response()->json(['error' => 'No payment found'], 400);

                $payment = PaymentModel::where('purpose', $purpose)->firstOrFail();

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
                    // 'trace' => $e->getTraceAsString(),
                    // 'data' => $data,
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

    public function getLastPayment($payment_request_id)
    {
        $api = $this->createAPI();
        $payment_request = $api->getPaymentRequestDetails($payment_request_id);
        $ps = $payment_request['payments'];

        if (count($ps) == 0) return false;

        $payments = array();

        foreach ($ps as $p) {
            // Sample
            $id = $this->getPaymentIdFromLink($p);

            if (!$id) continue; // Skip if payment id is not found (invalid link

            $payment = $api->getPaymentDetails($id);
            array_push($payments, $payment);
        }

        // Check if any payment is successful
        foreach ($payments as $payment) {
            if ($payment['status'] === true && $payment['failure'] === null) {
                return $payment;
            }
        }

        // If no payment is successful, return the payment with the latest created_at
        $latest_payment = $payments[0];

        foreach ($payments as $payment) {
            if (Carbon::parse($payment['created_at']) > Carbon::parse($latest_payment['created_at'])) {
                $latest_payment = $payment;
            }
        }

        return $latest_payment;
    }

    public function getPaymentIdFromLink($link)
    {
        if (preg_match('/\/payments\/(.*?)\//', $link, $matches)) {
            // $matches[1] contains the captured value
            $result = $matches[1];
            return $result;
        } else {
            return false;
        }
    }
}
