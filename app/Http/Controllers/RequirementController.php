<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    public function index()
    {
        $dishes = Dish::all();
        return view('requirements.index', compact('dishes'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'dish_id' => 'required|exists:dishes,id',
            'portions' => 'required|integer|min:1',
        ]);

        $dish = Dish::findOrFail($request->dish_id);
        $portions = $request->portions;
        
        $recipes = Recipe::with('material')
            ->where('dish_id', $dish->id)
            ->get();

        $requirements = $recipes->map(function ($recipe) use ($portions) {
            return [
                'material_name' => $recipe->material->name,
                'total_quantity' => $recipe->quantity * $portions,
                'unit' => $recipe->unit,
                'is_ayam' => str_contains(strtolower($recipe->material->name), 'ayam'),
            ];
        });

        $has_ayam = $requirements->contains('is_ayam', true);

        return view('requirements.index', [
            'dishes' => Dish::all(),
            'selected_dish' => $dish,
            'portions' => $portions,
            'requirements' => $requirements,
            'has_ayam' => $has_ayam,
        ]);
    }
}
