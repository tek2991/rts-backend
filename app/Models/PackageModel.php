<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageModel extends Model
{
    protected $fillable = [
        'name',
        'duration_in_days',
        'price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function coupons()
    {
        return $this->hasMany(CouponModel::class);
    }

    public function subscriptions()
    {
        return $this->morphMany(SubscriptionModel::class, 'subscribable');
    }
}
