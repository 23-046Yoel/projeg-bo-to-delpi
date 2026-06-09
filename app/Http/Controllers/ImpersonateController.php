<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImpersonateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function impersonate(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
        ]);

        // Check using the raw original role from DB
        if (!auth()->user()->isRealAdmin()) {
            abort(403, 'Hanya Master Admin yang dapat menggunakan fitur ini.');
        }

        // Store active impersonation role in session
        session(['impersonated_role' => $request->role]);

        return redirect()->route('dashboard')->with('success', 'Sekarang melihat sebagai role: ' . auth()->user()->role_title);
    }

    public function stop()
    {
        if (!auth()->user()->isRealAdmin()) {
            abort(403);
        }

        session()->forget('impersonated_role');

        return redirect()->route('dashboard')->with('success', 'Kembali ke Master Admin.');
    }
}
