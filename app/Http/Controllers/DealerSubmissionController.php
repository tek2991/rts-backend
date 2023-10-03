<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DealerSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dealer-submission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
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
