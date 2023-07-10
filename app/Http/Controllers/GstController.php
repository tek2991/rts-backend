<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GstController extends Controller
{
    public function index()
    {
        return view('gst.index');
    }
}
