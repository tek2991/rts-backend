<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function s3Url()
    {
        $mins = 5;
        $url = Storage::disk('s3')->temporaryUrl(
            'images/' . $this->filename,
            now()->addMinutes($mins)
        );
        return $url;
    }
}
