<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivationCode extends Model
{
    protected $fillable = [
        'code',
        'duration_in_days',
        'price',
        'user_id',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'duration_in_days' => 'integer',
        'price' => 'integer',
        'user_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
