<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'promoter_name',
        'max_use',
        'discount_percentage',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'max_use' => 'integer',
        'discount_percentage' => 'integer',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function usage()
    {
        return $this->subscriptions()->count();
    }

    public function isExpired()
    {
        return $this->max_use <= $this->usage();
    }
}
