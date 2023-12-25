<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = [
        'device_gallery_id',
        'device_id',
        'user_id',
        'media_type',
        'media_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
