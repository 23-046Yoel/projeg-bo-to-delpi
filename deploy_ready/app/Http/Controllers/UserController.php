<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sppg;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('sppg')->latest()->paginate(20);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $sppgs = Sppg::all();
        $roles = [
            User::ROLE_ADMIN => 'Master Admin',
            User::ROLE_FINANCE => 'Finance',
            User::ROLE_WAREHOUSE => 'Warehouse',
            User::ROLE_ASLAP => 'Aslap',
            User::ROLE_DRIVER => 'Driver',
            User::ROLE_HEAD => 'Head',
            'volunteer' => 'Volunteer'
        ];
        return view('users.create', compact('sppgs', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $sppgs = Sppg::all();
        $roles = [
            User::ROLE_ADMIN => 'Master Admin',
            User::ROLE_FINANCE => 'Finance',
            User::ROLE_WAREHOUSE => 'Warehouse',
            User::ROLE_ASLAP => 'Aslap',
            User::ROLE_DRIVER => 'Driver',
            User::ROLE_HEAD => 'Head',
            'volunteer' => 'Volunteer'
        ];
        return view('users.edit', compact('user', 'sppgs', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
