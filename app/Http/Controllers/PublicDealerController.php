<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;
use App\Models\DealerSubmission;
use Illuminate\Support\Facades\Mail;
use App\Mail\DealershipRequestSubmitted;

class PublicDealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dealer-public.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dealer-public.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['required', 'max:255'],
            'email' => ['nullable', 'email'],
            'mobile_number' => ['required', 'digits:10'],
            'message' => ['nullable', 'max:255'],
            'acknowledgement' => ['required', 'accepted'],
        ]);

        // Add blank address
        $data['address'] = '';

        $dealer_submission = DealerSubmission::create($data);

        // Send email to admin
        Mail::to(config('app.admin_email'))->send(new DealershipRequestSubmitted($dealer_submission));

        return redirect()->route('public.dealer.index')->banner('Dealership request submitted successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dealer $dealer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dealer $dealer)
    {
        //
    }
}
