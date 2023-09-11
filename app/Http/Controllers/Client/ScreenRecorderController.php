<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScreenRecorderController extends Controller
{
    public function index()
    {
        return view('client.screen-recorder');
    }

    public function destroy($id)
    {
        $screen_recording = auth()->user()->screenRecordings()->findOrFail($id);
        $screen_recording->delete();
        return redirect()->route('client.screen-recorder')->banner('Screen Recording deleted successfully!');
    }
}
