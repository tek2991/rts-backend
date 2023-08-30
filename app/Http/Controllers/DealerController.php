<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\District;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Dealer::class);
        return view('dealer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Dealer::class);
        $districts = District::all();
        return view('dealer.create', compact('districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:dealers,email'],
            'phone' => ['required', 'numeric', 'unique:dealers,phone'],
            'address' => ['required', 'max:255'],
            'district_id' => ['required', 'exists:districts,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        Dealer::create($data);

        return redirect()->route('dealer.index')->banner('Dealer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dealer $dealer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dealer $dealer)
    {
        $this->authorize('update', $dealer);
        $districts = District::all();
        return view('dealer.edit', compact('dealer', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dealer $dealer)
    {
        $data = $this->validate($request, [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:dealers,email,' . $dealer->id],
            'phone' => ['required', 'numeric', 'unique:dealers,phone,' . $dealer->id],
            'address' => ['required', 'max:255'],
            'district_id' => ['required', 'exists:districts,id'],
            'is_active' => ['required', 'boolean'],
        ]);

        $dealer->update($data);

        return redirect()->route('dealer.index')->banner('Dealer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dealer $dealer)
    {
        //
    }
}
