<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'coupon_id',
        'activation_code_id',
        'started_at',
        'expires_at',
        'payment_method',
        'gross_amount',
        'discount_amount',
        'net_amount',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'gross_amount' => 'integer',
        'discount_amount' => 'integer',
        'net_amount' => 'integer',
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

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
