<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponModel extends Model
{
    protected $fillable = [
        'code',
        'promoter_name',
        'package_id',
        'max_use',
        'discount_percentage',
    ];

    protected $casts = [
        'max_use' => 'integer',
        'discount_percentage' => 'integer',
    ];

    public function package()
    {
        return $this->belongsTo(PackageModel::class);
    }
}
