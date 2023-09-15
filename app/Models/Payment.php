<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Payment extends Model
{
    // Fillable
    protected $fillable = [
        'payment_id',
        'payment_request_id',
        'payment_status',
        'currency',
        'amount',
        'fees',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'purpose',
        'shorturl',
        'longurl',
        'mac',
        'verified',
        'webhook_called',
        'webhook_verified',
    ];

    // Casts
    protected $casts = [
        'verified' => 'boolean',
        'webhook_called' => 'boolean',
        'webhook_verified' => 'boolean',
        'amount' => 'float',
    ];

    // Appends
    protected $appends = [
        'amount',
        'fees',
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

    public function verified($query)
    {
        return $query->where('verified', true)->where('webhook_verified', true);
    }
}
