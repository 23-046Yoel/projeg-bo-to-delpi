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
        ]);

        Recipe::create($validated);

        return redirect()->back()->with('success', 'Bahan berhasil ditambahkan ke resep.');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->back()->with('success', 'Bahan berhasil dihapus dari resep.');
    }
}
