<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-menus');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Dish::query()->withCount('recipes');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $dishes = $query->paginate(9)->withQueryString();
        return view('dishes.index', compact('dishes', 'search'));
    }

    public function create()
    {
        return view('dishes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'youtube_url'   => 'nullable|url|max:500',
            'thumbnail_url' => 'nullable|url|max:500',
        ]);

        Dish::create($validated);

        return redirect()->route('dishes.index')->with('success', 'Hidangan berhasil ditambahkan.');
    }

    public function show(Dish $dish)
    {
        $dish->load('recipes.material');
        return view('dishes.show', compact('dish'));
    }

    public function edit(Dish $dish)
    {
        return view('dishes.edit', compact('dish'));
    }

    public function update(Request $request, Dish $dish)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'youtube_url'   => 'nullable|url|max:500',
            'thumbnail_url' => 'nullable|url|max:500',
        ]);

        $dish->update($validated);

        return redirect()->route('dishes.index')->with('success', 'Hidangan berhasil diperbarui.');
    }

    public function destroy(Dish $dish)
    {
        $dish->delete();
        return redirect()->route('dishes.index')->with('success', 'Hidangan berhasil dihapus.');
    }

    public function tutorial(Dish $dish)
    {
        $dish->load('recipes.material');
        return view('dishes.tutorial', compact('dish'));
    }
}
