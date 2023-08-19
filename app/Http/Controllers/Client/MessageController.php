<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index()
    {
        return view('client.message');
    }
}
