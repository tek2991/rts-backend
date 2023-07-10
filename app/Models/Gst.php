<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gst extends Model
{
    protected $fillable = [
        'name',
        'rate',
    ];

    protected $casts = [
        'rate' => 'integer',
    ];
}
