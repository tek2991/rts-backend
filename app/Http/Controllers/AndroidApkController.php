<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AndroidApkController extends Controller
{
    public function index()
    {
        return view('client.android-apk');
    }


    public function download()
    {
        // If user does not have subscription then redirect to expired page
        if(!Auth::user()->hasActiveSubscription()) {
            return redirect()->route('client.subscription.expired');
        }

        // file at storage/app/app-release.apk
        $file_location = storage_path('app/app-release.apk');

        $headers = array(
            'Content-Type: application/apk',
        );

        return response()->download($file_location, 'app.apk', $headers);
    }
}
