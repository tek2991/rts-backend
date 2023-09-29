<?php

namespace App\Http\Controllers;

use App\Models\ApkVersion;
use Illuminate\Http\Request;

class ApkVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('update', ApkVersion::class);
        return view('apk-version.index');
    }
}
