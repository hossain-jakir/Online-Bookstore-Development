<?php

namespace App\Http\Controllers\Backend;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{

    public function __construct()
    {
        // Authorization check
        $this->middleware(function ($request, $next) {
            if (Gate::denies('view shop')) {
                abort(403, 'Unauthorized');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $shop = Shop::first();
        return view('Backend.pages.shop.index', compact('shop'));
    }

    // Update the shop details
    public function update(Request $request)
    {

        // authorize
        if (Gate::denies('edit shop')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:100',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'tax' => 'nullable|numeric',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'short_description' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string|max:20',
        ]);

        $shop = Shop::first();

        // Handle file uploads for logo and favicon
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $shop->logo = $logoPath;
        }
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            $shop->favicon = $faviconPath;
        }

        $shop->update($request->only([
            'name', 'address', 'phone', 'email','tax', 'latitude', 'longitude',
            'short_description', 'website', 'facebook', 'twitter',
            'instagram', 'linkedin', 'whatsapp'
        ]));

        $key = 'shop_data';
        Cache::forget($key);

        session()->flash('success', 'Shop details updated successfully.');
        return redirect()->route('backend.shop.index')->with('success', 'Shop details updated successfully.');
    }
}

