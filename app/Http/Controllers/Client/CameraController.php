<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CameraController extends Controller
{
    public function index()
    {
        return view('client.camera');
    }

    public function destroy($id)
    {
        $image = auth()->user()->images()->findOrFail($id);
        $image->delete();
        return redirect()->route('client.camera')->banner('Image deleted successfully!');
    }
}
