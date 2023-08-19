<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocatePhoneController extends Controller
{
    public function index()
    {
        return view('client.locate-phone');
    }
}
