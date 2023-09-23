<?php

namespace App\Models;

use Instamojo\Instamojo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function recheck()
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

        try {

            // Get payment details
            $response = $api->getPaymentDetails($this->payment_id);

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

                    return false;
                }

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
