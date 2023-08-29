<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address', 'district_id', 'is_active'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
