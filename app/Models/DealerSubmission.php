<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealerSubmission extends Model
{
    protected $fillable = [
        'name',
        'mobile_number',
        'email',
        'address',
        'message',
    ];
}
