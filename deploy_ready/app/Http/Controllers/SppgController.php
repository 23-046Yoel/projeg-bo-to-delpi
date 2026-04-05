<?php

namespace App\Http\Controllers;

use App\Models\Sppg;
use Illuminate\Http\Request;

class SppgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sppgs = Sppg::paginate(10);
        return view('sppgs.index', compact('sppgs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sppgs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        Sppg::create($validated);

        return redirect()->route('sppgs.index')->with('success', 'Dapur berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sppg $sppg)
    {
        return view('sppgs.show', compact('sppg'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sppg $sppg)
    {
        return view('sppgs.edit', compact('sppg'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sppg $sppg)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $sppg->update($validated);

        return redirect()->route('sppgs.index')->with('success', 'Dapur berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sppg $sppg)
    {
        $sppg->delete();
        return redirect()->route('sppgs.index')->with('success', 'Dapur berhasil dihapus.');
    }
}
