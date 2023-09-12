<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HideAppController extends Controller
{
    public function index()
    {
        return view('client.hide-app');
    }
}
