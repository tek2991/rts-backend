<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientActivationCodeController extends Controller
{
    public function start()
    {
        return view('client.activation-code.index');
    }
}
