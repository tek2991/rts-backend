<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ActivationCode;

class ActivationCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', ActivationCode::class);
        return view('activation-code.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', ActivationCode::class);
        return view('activation-code.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivationCode $activationCode)
    {
        $this->authorize('view', $activationCode);
        return view('activation-code.show', compact('activationCode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivationCode $activationCode)
    {
        $this->authorize('update', $activationCode);
        return view('activation-code.edit', compact('activationCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivationCode $activationCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivationCode $activationCode)
    {
        //
    }
}
