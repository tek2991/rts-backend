<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class ClientPackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('client.package.index', compact('packages'));
    }
}
