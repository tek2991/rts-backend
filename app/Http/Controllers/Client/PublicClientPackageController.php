<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PublicClientPackageController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        return view('client.package.public.index', compact('packages'));
    }

    public function show(Package $package)
    {
        if(!$package->is_active) abort(404  , 'Package not found.');
        return view('client.package.public.show', compact('package'));
    }
}
