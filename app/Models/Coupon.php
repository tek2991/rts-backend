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
    ];

    protected $casts = [
        'max_use' => 'integer',
        'discount_percentage' => 'integer',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
