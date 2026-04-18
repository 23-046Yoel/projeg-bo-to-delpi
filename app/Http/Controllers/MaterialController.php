<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sppgId = $request->input('sppg_id');
        $query = Material::query();

        // 1. Scoping
        if (auth()->check() && !auth()->user()->isAdmin() && auth()->user()->sppg_id) {
            $query->where('sppg_id', auth()->user()->sppg_id);
        } elseif ($sppgId) {
            $query->where('sppg_id', $sppgId);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $materials = $query->latest()->paginate(10)->withQueryString();
        $sppgs = \App\Models\Sppg::all(); // For admin filter dropdown
        
        return view('materials.index', compact('materials', 'search', 'sppgs', 'sppgId'));
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'category'             => 'required|string',
            'unit'                 => 'nullable|string|max:50',
            'price'                => 'numeric|min:0',
            'stock'                => 'numeric|min:0',
            'expiry_date'          => 'nullable|date',
            'notes'                => 'nullable|string|max:1000',
            'last_price'           => 'nullable|numeric|min:0',
            'estimated_daily_need' => 'nullable|numeric|min:0',
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
