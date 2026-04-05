<?php

namespace App\Http\Controllers;

use App\Models\Sppg;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierRegistrationController extends Controller
{
    public function index()
    {
        $sppgs = Sppg::all();
        return view('suppliers.register', compact('sppgs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'items' => 'required|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
        ]);

        Supplier::create($validated);

        return back()->with('success', 'Pendaftaran berhasil! Kami akan menghubungi Anda segera.');
    }
}
