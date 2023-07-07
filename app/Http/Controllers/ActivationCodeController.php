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
        $this->authorize('create', ActivationCode::class);
        
        $request->validate([
            'code' => 'required|string|max:255|unique:activation_codes',
            'duration' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'expires_at' => 'required|date|after:today',
        ]);

        // Capitalize the code
        $request->merge([
            'code' => strtoupper($request->code),
        ]);


        ActivationCode::create([
            'code' => $request->code,
            'duration_in_days' => $request->duration,
            'price' => $request->price,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('activation-code.index')->banner('Activation code created successfully: ' . $request->code);
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivationCode $activationCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivationCode $activationCode)
    {
        //
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
