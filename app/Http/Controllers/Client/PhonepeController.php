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

    public function saltNhash($str)
    {
        $salt = config('services.phonepe.salt');
        $str = $str . $salt . "$@%#^$";
        $hash = hash('sha256', $str);
        return $hash;
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
            $merchant_id = config('services.phonepe.merchant_id');
            $shmtid = $this->saltNhash($merchant_id . $merchant_transaction_id);

            $data = array(
                'merchantId' => config('services.phonepe.merchant_id'),
                'merchantTransactionId' => $merchant_transaction_id,
                'merchantUserId' => $merchant_user_id,
                'amount' => $gross_amount * 100,
                'redirectUrl' => route('client.phonepe.payment.success', ['mid' => $merchant_id, 'mtid' => $merchant_transaction_id, 'shmtid' => $shmtid]),
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

            if (!isset($response->data->instrumentResponse->redirectInfo->url)) {
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
                    'longurl' => null,
                    'mac' => null,
                    // phonepe
                    'gateway' => 'phonepe',
                    'phonepe_order_id' => null,
                    'phonepe_longurl' => $response->data->instrumentResponse->redirectInfo->url,
                    'phonepe_merchant_transaction_id' => $response->data->merchantTransactionId,
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

    public function success(Request $request, $mid, $mtid, $shmtid)
    {
        try {
            // Check if shmtid is valid
            if ($shmtid != $this->saltNhash($mid . $mtid)) {
                throw new \Exception("Invalid shmtid");
            }

            // Prepare status xheader
            $salt = config('services.phonepe.salt');
            $salt_index = config('services.phonepe.salt_index');

            $finalXHeader = hash('sha256', config('services.phonepe.status_endpoint') . '/' . $mid . '/' . $mtid . $salt) . '###' . $salt_index;

            $url = config('services.phonepe.production') ? config('services.phonepe.prod_url') : config('services.phonepe.preprod_url');
            $url .= config('services.phonepe.status_endpoint') . '/' . $mid . '/' . $mtid;

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "accept: application/json",
                    "X-VERIFY: " . $finalXHeader,
                    "X-MERCHANT-ID: " . $mid,
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

            if (config('services.phonepe.merchant_id') != $mid) {
                throw new \Exception("Invalid merchant id");
            }

            $payment = PaymentModel::where('phonepe_merchant_transaction_id', $mtid)->first();

            if (!$payment) {
                throw new \Exception("Payment not found");
            }

            if (isset($response->success)) {
                $payment->update([
                    'payment_id' => null,
                    'payment_status' => $response->success == true ? 'success' : 'failed',
                    'currency' => "INR",
                    'amount' => $response->data->amount / 100,
                    'fees' => null,
                    'taxes' => null,
                    'instrument_type' => null,
                    'billing_instrument' => null,
                    'redirected' => true,

                    // phonepe
                    'phonepe_order_id' => null,
                    'phonepe_merchant_transaction_id' => $response->data->merchantTransactionId,
                    'phonepe_transaction_id' => $response->data->transactionId,
                    'phonepe_payment_type' => $response->success == true ? $response->data->paymentInstrument->type : null,
                ]);

                if ($response->success == true) {
                    $subscription = $payment->subscription;

                    $subscription->update([
                        'status' => 'paid',
                    ]);
                } else {
                    $payment->update([
                        'failure_reason' => $response->code,
                        'failure_message' => $response->message,
                    ]);

                    $payment->subscription()->update([
                        'status' => $response->code == "PAYMENT_PENDING" ? 'pending' : 'failed',
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
        $headers = getallheaders();

        $XVerify = $headers['X-VERIFY'];

        $salt = config('services.phonepe.salt');
        $salt_index = config('services.phonepe.salt_index');

        $response = $data['response'];

        $xheader = hash('sha256', $response . $salt) . '###' . $salt_index;

        if ($xheader != $XVerify) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid X-VERIFY',
            ]);
        }

        $response = json_decode(base64_decode($response));

        try {
            $mid = $response->data->merchantId;
            $mtid = $response->data->merchantTransactionId;

            $finalXHeader = hash('sha256', config('services.phonepe.status_endpoint') . '/' . $mid . '/' . $mtid . $salt) . '###' . $salt_index;

            $url = config('services.phonepe.production') ? config('services.phonepe.prod_url') : config('services.phonepe.preprod_url');
            $url .= config('services.phonepe.status_endpoint') . '/' . $mid . '/' . $mtid;

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "accept: application/json",
                    "X-VERIFY: " . $finalXHeader,
                    "X-MERCHANT-ID: " . $mid,
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

            if (config('services.phonepe.merchant_id') != $mid) {
                throw new \Exception("Invalid merchant id");
            }

            $payment = PaymentModel::where('phonepe_merchant_transaction_id', $mtid)->first();

            if (!$payment) {
                throw new \Exception("Payment not found");
            }

            if (isset($response->success)) {
                $payment->update([
                    'payment_id' => null,
                    'payment_status' => $response->success == true ? 'success' : 'failed',
                    'currency' => "INR",
                    'amount' => $response->data->amount / 100,
                    'fees' => null,
                    'taxes' => null,
                    'instrument_type' => null,
                    'billing_instrument' => null,
                    'redirected' => true,

                    // phonepe
                    'phonepe_order_id' => null,
                    'phonepe_merchant_transaction_id' => $response->data->merchantTransactionId,
                    'phonepe_transaction_id' => $response->data->transactionId,
                    'phonepe_payment_type' => $response->success == true ? $response->data->paymentInstrument->type : null,
                ]);

                if ($response->success == true) {
                    $subscription = $payment->subscription;

                    $subscription->update([
                        'status' => 'paid',
                    ]);
                } else {
                    $payment->update([
                        'failure_reason' => $response->code,
                        'failure_message' => $response->message,
                    ]);

                    $payment->subscription()->update([
                        'status' => $response->code == "PAYMENT_PENDING" ? 'pending' : 'failed',
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Payment status updated',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment status not updated',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
