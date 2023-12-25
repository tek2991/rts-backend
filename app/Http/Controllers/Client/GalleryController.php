<?php

namespace App\Http\Controllers\Client;

use App\Models\GalleryItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        return view('client.gallery');
    }

    public function destroy($id)
    {
        $image = GalleryItem::findOrFail($id);
        $image->delete();
        return redirect()->route('client.gallery')->banner('File deleted successfully!');
    }
}
