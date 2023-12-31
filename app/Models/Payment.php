<?php

namespace App\Models;

use Instamojo\Instamojo;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Razorpay\Api\Api as RazorpayApi;

class Payment extends Model
{
    // Fillable
    protected $fillable = [
        'payment_id',
        'webhook_payment_id',
        'payment_request_id',
        'payment_status',
        'currency',
        'amount',
        'fees',
        'taxes',
        'instrument_type',
        'billing_instrument',
        'failure_reason',
        'failure_message',
        'bank_reference_number',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'purpose',
        'shorturl',
        'longurl',
        'mac',
        'redirected',
        'webhook_verified',
        'user_id',

        'gateway',

        // Phonepe
        'phonepe_order_id',
        'phonepe_longurl',
        'phonepe_merchant_transaction_id',
        'phonepe_transaction_id',
        'phonepe_payment_type',

        // Razorpay
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
    ];

    // Casts
    protected $casts = [
        'redirected' => 'boolean',
        'webhook_verified' => 'boolean',
        'amount' => 'float',
    ];

    // Appends
    protected $appends = [
        'amount',
        'fees',
        'taxes'
    ];

    // Relationships
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    // Accessors & Mutators
    /**
     * Interact with the amount_in_cents column.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $attributes['amount_in_cents'] / 100,

            set: fn ($value) => [
                'amount_in_cents' => $value * 100,
            ]
        );
    }

    /**
     * Interact with the fees_in_cents column.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function fees(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $attributes['fees_in_cents'] / 100,

            set: fn ($value) => [
                'fees_in_cents' => $value * 100,
            ]
        );
    }

    /**
     * Interact with the total_taxes_in_cents column.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function taxes(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $attributes['taxes_in_cents'] / 100,

            set: fn ($value) => [
                'taxes_in_cents' => $value * 100,
            ]
        );
    }

    public function verified($query)
    {
        return $query->where('verified', true)->where('webhook_verified', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recheck_instamojo(){
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

        try {
            $payment_request = $api->getPaymentRequestDetails($this->payment_request_id);
            $ps = $payment_request['payments'];
            $payments = array();

            // If there are no payments, return false
            if (count($ps) == 0) return "No payments found";

            foreach ($ps as $p) {
                $id = null;

                // Sample
                if (preg_match('/\/payments\/(.*?)\//', $p, $matches)) {
                    // $matches[1] contains the captured value
                    $id = $matches[1];
                }

                if (!$id) continue; // Skip if payment id is not found (invalid link)

                $payment = $api->getPaymentDetails($id);
                array_push($payments, $payment);
            }

            $latest_payment = null;

            // Check if any payment is successful
            foreach ($payments as $payment) {
                if ($payment['status'] === true && $payment['failure'] === null) {
                    $latest_payment = $payment;
                    break;
                }
            }

            if ($latest_payment === null) {
                // If no payment is successful, return the payment with the latest created_at
                $latest_payment = $payments[0];

                foreach ($payments as $payment) {
                    if (Carbon::parse($payment['created_at']) > Carbon::parse($latest_payment['created_at'])) {
                        $latest_payment = $payment;
                    }
                }
            }

            $response = $latest_payment;

            if (array_key_exists('status', $response)) {
                $this->update([
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
                    $subscription = $this->subscription;

                    $subscription->update([
                        'status' => 'paid',
                    ]);
                } else {
                    $this->update([
                        'failure_reason' => $response['failure']['reason'],
                        'failure_message' => $response['failure']['message'],
                    ]);

                    $this->subscription()->update([
                        'status' => 'failed',
                    ]);

                    return $response['failure']['message'];
                }

                return true;
            } else {
                return "Invalid payment response";
            }
        } catch (\Exception $e) {
            return $e->getMessage() . " - exception";
        }
    }

    public function recheck_phonepe(){
    }

    public function recheck_razorpay(){
        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        try {
            $api = new RazorpayApi($key, $secret);

            $order = $api->order->fetch($this->razorpay_order_id);

            // If order status is paid
            if ($order->status == 'paid') {
                $razorpay_payments = $order->payments();
                $successfull_paymenmt = null;
                foreach ($razorpay_payments->items as $payment) {
                    if ($payment->status == 'captured') {
                        $successfull_paymenmt = $payment;
                        break;
                    }
                }

                if ($successfull_paymenmt == null) {
                    return "No successful payment found";
                }

                $this->update([
                    'payment_status' => 'success',
                    'redirected' => true,
                    'razorpay_payment_id' => $successfull_paymenmt->id,
                ]);

                $subscription = $payment->subscription;

                $subscription->update([
                    'status' => 'paid'
                ]);
                return true;
            } else {
                return "Payment failed, Status: " . $order->status . ", Attempts: " . $order->attempts;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function recheck()
    {
        if ($this->gateway == 'instamojo') {
            return $this->recheck_instamojo();
        } else if ($this->gateway == 'phonepe') {
            // return $this->recheck_phonepe();
        } else if ($this->gateway == 'razorpay') {
            return $this->recheck_razorpay();
        } else {
            return "Invalid gateway";
        }
    }
}
