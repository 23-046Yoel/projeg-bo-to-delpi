<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dish_id' => 'required|exists:dishes,id',
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:0.0001',
            'unit' => 'required|string|max:20',
            'notes' => 'nullable|string|max:255',
            'steps' => 'nullable|array',
            'youtube_url' => 'nullable|string|url',
        ]);

        Recipe::create($validated);

        return redirect()->back()->with('success', 'Bahan dan instruksi berhasil ditambahkan ke resep.');
    }

    public function edit(Recipe $recipe)
    {
        $recipe->load('material', 'dish');
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
            'notes' => 'nullable|string|max:255',
        ]);

        $recipe->update($validated);

        return redirect()->back()->with('success', 'Gramasi bahan berhasil diperbarui.');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->back()->with('success', 'Bahan berhasil dihapus dari resep.');
    }
}
