<?php

namespace App\Http\Controllers\Backend;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')
        ->where('isDeleted', 'no')
        ->paginate(10);

        return view('Backend.pages.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('Backend.pages.coupon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $coupon = Coupon::create($request->all());
        return redirect()->route('backend.coupon.index')->with('success', 'Coupon created successfully!');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('Backend.pages.coupon.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $coupon->update($request->all());
        return redirect()->route('backend.coupon.index')->with('success', 'Coupon updated successfully!');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('backend.coupon.index')->with('success', 'Coupon deleted successfully!');
    }
}
