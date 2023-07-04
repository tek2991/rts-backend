<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class ClientPackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        return view('client.package.index', compact('packages'));
    }
}
