<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'package_name',
        'coupon_id',
        'coupon_code',
        'coupon_promoter_name',
        'activation_code_id',
        'activation_code',
        'plan_net_amount',
        'plan_tax',
        'started_at',
        'expires_at',
        'duration_in_days',
        'gross_price',
        'discount_amount',
        'net_amount',
        'tax',
        'price',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        
        'plan_net_amount' => 'integer',
        'plan_tax' => 'integer',
        
        
        'duration_in_days' => 'integer',
        'gross_price' => 'integer',
        'discount_amount' => 'integer',
        'net_amount' => 'integer',
        'tax' => 'integer',
        'price' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function activationCode()
    {
        return $this->belongsTo(ActivationCode::class);
    }
}
