<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Coupon::class);
        return view('coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Coupon::class);
        return view('coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Coupon::class);
        
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons',
            'promoter_name' => 'required|string|max:255',
            'max_use' => 'required|integer|min:1',
            'discount_percentage' => 'required|integer|min:1',
        ]);

        Coupon::create([
            'code' => $request->code,
            'promoter_name' => $request->promoter_name,
            'max_use' => $request->max_use,
            'discount_percentage' => $request->discount_percentage,
        ]);

        return redirect()->route('coupon.index')->banner('Coupon created successfully: ' . $request->code);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        $this->authorize('update', $coupon);
        return view('coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);
        
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,' . $coupon->id,
            'promoter_name' => 'required|string|max:255',
            'max_use' => 'required|integer|min:1',
            'discount_percentage' => 'required|integer|min:1',
        ]);

        $coupon->update([
            'code' => $request->code,
            'promoter_name' => $request->promoter_name,
            'max_use' => $request->max_use,
            'discount_percentage' => $request->discount_percentage,
        ]);

        return redirect()->route('coupon.index')->banner('Coupon updated successfully: ' . $request->code);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        //
    }
}
