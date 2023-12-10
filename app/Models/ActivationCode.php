<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivationCode extends Model
{
    protected $fillable = [
        'code',
        'duration_in_days',
        'net_amount',
        'tax',
        'price',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'duration_in_days' => 'integer',
        'price' => 'integer',
        'expires_at' => 'datetime',
    ];


    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function user()
    {
        if($this->subscription()->exists()) {
            return $this->subscription->user();
        }
        return null;
    }

    public function isValid()
    {
        return $this->used_at === null && $this->expires_at > now() && $this->subscription === null;
    }

    public function isUsed()
    {
        return $this->used_at !== null || $this->subscription()->exists();
    }
}
