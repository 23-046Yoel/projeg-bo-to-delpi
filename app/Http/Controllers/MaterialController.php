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
        $materials = Material::latest()->paginate(10);
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
            'type' => 'required|in:raw,processed',
            'unit' => 'nullable|string|max:50',
            'price' => 'numeric|min:0',
            'grammage' => 'numeric|min:0',
            'stock' => 'numeric|min:0',
        ]);

        Material::create(array_merge($validated, [
            'sppg_id' => auth()->user()->sppg_id
        ]));

        return redirect()->route('materials.index')->with('success', 'Material created successfully.');
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:raw,processed',
            'unit' => 'nullable|string|max:50',
            'price' => 'numeric|min:0',
            'stock' => 'numeric|min:0',
        ]);

        $material->update($validated);

        return redirect()->route('materials.index')->with('success', 'Material updated successfully.');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }
}
