<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionModel extends Model
{
    protected $fillable = [
        'user_id',
        'started_at',
        'expires_at',
        'subscribable_id',
        'subscribable_type',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'subscribable_id' => 'integer',
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function subscribable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }
}
