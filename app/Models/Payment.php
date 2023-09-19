<?php

namespace App\Models;

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
}
