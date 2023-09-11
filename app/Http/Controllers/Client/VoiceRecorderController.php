<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoiceRecorderController extends Controller
{
    public function index()
    {
        return view('client.voice-recorder');
    }

    public function destroy($id)
    {
        $recording = auth()->user()->recordings()->findOrFail($id);
        $recording->delete();
        return redirect()->route('client.voice-recorder')->banner('Recording deleted successfully!');
    }
}
