<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoRecorderController extends Controller
{
    public function index()
    {
        return view('client.video-recorder');
    }

    public function destroy($id)
    {
        $video = auth()->user()->videos()->findOrFail($id);
        $video->delete();
        return redirect()->route('client.video-recorder')->banner('Video deleted successfully!');
    }
}
