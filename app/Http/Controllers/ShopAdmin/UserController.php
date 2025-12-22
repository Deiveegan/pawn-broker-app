<?php

namespace App\Http\Controllers\ShopAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('shop_id', auth()->user()->shop_id)
            ->where('id', '!=', auth()->id())
            ->get();
        return view('shop-admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('shop-admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,staff',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'shop_id' => auth()->user()->shop_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        if ($user->shop_id !== auth()->user()->shop_id) {
            abort(403);
        }
        return view('shop-admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->shop_id !== auth()->user()->shop_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->shop_id !== auth()->user()->shop_id) {
            abort(403);
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
