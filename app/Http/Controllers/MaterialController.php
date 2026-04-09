<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Material::query();

        if (auth()->check() && !auth()->user()->isAdmin() && auth()->user()->sppg_id) {
            $query->where('sppg_id', auth()->user()->sppg_id);
        }

        $materials = $query->latest()->paginate(10);
        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'unit' => 'nullable|string|max:50',
            'price' => 'numeric|min:0',
            'stock' => 'numeric|min:0',
            'expiry_date' => 'nullable|date',
        ]);

        Material::create(array_merge($validated, [
            'sppg_id' => auth()->user()->sppg_id
        ]));

        return redirect()->route('materials.index')->with('success', 'Bahan Baku berhasil ditambahkan.');
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'unit' => 'nullable|string|max:50',
            'price' => 'numeric|min:0',
            'stock' => 'numeric|min:0',
            'expiry_date' => 'nullable|date',
        ]);

        $material->update($validated);

        return redirect()->route('materials.index')->with('success', 'Bahan Baku berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }
}
