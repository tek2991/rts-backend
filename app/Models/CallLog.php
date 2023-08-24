<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    // Table name
    protected $table = 'call_logs';
    protected $fillable = [
        'user_id',
        'name',
        'number',
        'duration',
        'date',
    ];

    protected $dates = [
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
