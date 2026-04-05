<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Dish;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::withCount('dishes')->latest('date')->paginate(10);
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $dishes = Dish::all();
        return view('menus.create', compact('dishes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'content' => 'nullable|string',
            'dishes' => 'required|array',
            'dishes.*.id' => 'required|exists:dishes,id',
            'dishes.*.portions' => 'required|integer|min:1',
        ]);

        $menu = Menu::create([
            'date' => $validated['date'],
            'content' => $validated['content'] ?? null,
            'sppg_id' => auth()->user()->sppg_id
        ]);

        foreach ($validated['dishes'] as $dishData) {
            $menu->dishes()->attach($dishData['id'], ['portions' => $dishData['portions']]);
        }

        return redirect()->route('menus.index')->with('success', 'Menu harian berhasil disimpan.');
    }

    public function show(Menu $menu)
    {
        $menu->load('dishes.recipes.material');
        
        // Calculate total material requirement for this menu
        $requirements = [];
        foreach ($menu->dishes as $dish) {
            $portions = $dish->pivot->portions;
            foreach ($dish->recipes as $recipe) {
                $matId = $recipe->material_id;
                $needed = $recipe->quantity * $portions;
                
                if (!isset($requirements[$matId])) {
                    $requirements[$matId] = [
                        'name' => $recipe->material->name,
                        'total' => 0,
                        'unit' => $recipe->unit
                    ];
                }
                $requirements[$matId]['total'] += $needed;
            }
        }

        return view('menus.show', compact('menu', 'requirements'));
    }

    public function edit(Menu $menu)
    {
        $dishes = Dish::all();
        $selectedDishes = $menu->dishes->pluck('id')->toArray();
        return view('menus.edit', compact('menu', 'dishes', 'selectedDishes'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'content' => 'nullable|string',
            'dishes' => 'required|array',
            'dishes.*.id' => 'required|exists:dishes,id',
            'dishes.*.portions' => 'required|l|min:1',
        ]);

        $menu->update([
            'date' => $validated['date'],
            'content' => $validated['content'] ?? null,
        ]);

        $syncData = [];
        foreach ($validated['dishes'] as $dishData) {
            $syncData[$dishData['id']] = ['portions' => $dishData['portions']];
        }
        $menu->dishes()->sync($syncData);

        return redirect()->route('menus.index')->with('success', 'Menu harian berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu harian berhasil dihapus.');
    }
}
