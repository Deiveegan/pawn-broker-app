<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with(['users' => function($q) {
            $q->where('role', 'admin');
        }])->withCount(['customers', 'loans'])->latest()->paginate(15);
        
        if (request()->expectsJson()) {
            return response()->json($shops);
        }

        return view('super-admin.shops.index', compact('shops'));
    }

    public function create()
    {
        return view('super-admin.shops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_address' => 'nullable|string',
            'shop_logo' => 'nullable|image|max:2048',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        $logoPath = null;
        if ($request->hasFile('shop_logo')) {
            $logoPath = $request->file('shop_logo')->store('shop_logos', 'public');
        }

        $shop = Shop::create([
            'name' => $request->shop_name,
            'address' => $request->shop_address,
            'logo' => $logoPath,
            'is_active' => true,
        ]);

        $admin = User::create([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => Hash::make($request->admin_password),
            'role' => 'admin',
            'shop_id' => $shop->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Shop and Admin created successfully.',
                'shop' => $shop,
                'admin' => $admin
            ], 201);
        }

        return redirect()->route('super-admin.shops.index')->with('success', 'Shop and Admin created successfully.');
    }

    public function show(Shop $shop)
    {
        $shop->load(['users' => function($q) {
            $q->where('role', 'admin');
        }])->loadCount(['customers', 'loans']);
        if (request()->expectsJson()) {
            return response()->json($shop);
        }
        return view('super-admin.shops.show', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'address', 'is_active']);

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($shop->logo) {
                Storage::disk('public')->delete($shop->logo);
            }
            $data['logo'] = $request->file('logo')->store('shop_logos', 'public');
        }

        $shop->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Shop updated successfully.',
                'shop' => $shop
            ]);
        }

        return redirect()->route('super-admin.shops.index')->with('success', 'Shop updated successfully.');
    }

    public function destroy(Shop $shop)
    {
        if ($shop->logo) {
            Storage::disk('public')->delete($shop->logo);
        }
        $shop->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Shop deleted successfully.']);
        }

        return redirect()->route('super-admin.shops.index')->with('success', 'Shop deleted successfully.');
    }

    public function toggleStatus(Shop $shop)
    {
        $shop->update(['is_active' => !$shop->is_active]);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Shop status toggled successfully.',
                'is_active' => $shop->is_active
            ]);
        }

        return back()->with('success', 'Shop status toggled successfully.');
    }
}
