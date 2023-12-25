<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function s3Url()
    {
        $mins = 120;
        $type = $this->media_type == 'image' ? 'images/' : 'videos/';
        $url = Storage::disk('s3')->temporaryUrl(
            'gallery/' . $type . $this->filename,
            now()->addMinutes($mins)
        );
        return $url;
    }
}
