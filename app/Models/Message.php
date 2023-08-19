<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'message_id',
        'number',
        'date',
        'body',
        'is_inbox',
    ];

    protected $casts = [
        'date' => 'datetime',
        'is_inbox' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
