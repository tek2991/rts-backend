<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'filename',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
