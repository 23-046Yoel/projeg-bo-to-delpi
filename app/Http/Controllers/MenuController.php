<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Dish;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-menus');
    }
    
    public function index(Request $request)
    {
        $query = Menu::with('sppg');

        if ($request->has('sppg_id') && $request->sppg_id != '') {
            $query->where('sppg_id', $request->sppg_id);
        }

        $menus = $query->latest()->paginate(15)->withQueryString();
        $sppgs = Sppg::all();
        return view('menus.index', compact('menus', 'sppgs'));
    }

    public function create()
    {
        $dishes = Dish::all();
        $sppgs = \App\Models\Sppg::all();
        return view('menus.create', compact('dishes', 'sppgs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'content' => 'nullable|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
            'dishes' => 'required|array',
            'dishes.*.id' => 'required|exists:dishes,id',
            'dishes.*.porsi_kecil' => 'required|integer|min:0',
            'dishes.*.porsi_besar' => 'required|integer|min:0',
        ]);

        $menu = Menu::create([
            'date' => $validated['date'],
            'content' => $validated['content'] ?? null,
            'sppg_id' => $validated['sppg_id'] ?? auth()->user()->sppg_id
        ]);

        foreach ($validated['dishes'] as $dishData) {
            $menu->dishes()->attach($dishData['id'], [
                'porsi_kecil' => $dishData['porsi_kecil'],
                'porsi_besar' => $dishData['porsi_besar'],
                'portions' => $dishData['porsi_kecil'] + $dishData['porsi_besar']
            ]);
        }

        return redirect()->route('menus.index')->with('success', 'Menu harian berhasil disimpan dengan porsi ganda.');
    }

    public function show(Menu $menu)
    {
        $menu->load('dishes.recipes.material');
        
        $requirements = [];
        foreach ($menu->dishes as $dish) {
            // Kita jumlahkan kedua porsi untuk kalkulasi bahan (multiplier 1.0)
            // Anda bisa menyesuaikan multiplier di sini jika porsi kecil menggunakan gramasi berbeda
            $totalPortions = $dish->pivot->porsi_kecil + $dish->pivot->porsi_besar;
            
            foreach ($dish->recipes as $recipe) {
                $matId = $recipe->material_id;
                $needed = $recipe->quantity * $totalPortions;
                
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
        $sppgs = \App\Models\Sppg::all();
        $selectedDishes = $menu->dishes; // Ambil object agar pivot data tersedia
        return view('menus.edit', compact('menu', 'dishes', 'selectedDishes', 'sppgs'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'content' => 'nullable|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
            'dishes' => 'required|array',
            'dishes.*.id' => 'required|exists:dishes,id',
            'dishes.*.porsi_kecil' => 'required|integer|min:0',
            'dishes.*.porsi_besar' => 'required|integer|min:0',
        ]);

        $menu->update([
            'date' => $validated['date'],
            'content' => $validated['content'] ?? null,
            'sppg_id' => $validated['sppg_id'] ?? $menu->sppg_id
        ]);

        $syncData = [];
        foreach ($validated['dishes'] as $dishData) {
            $syncData[$dishData['id']] = [
                'porsi_kecil' => $dishData['porsi_kecil'],
                'porsi_besar' => $dishData['porsi_besar'],
                'portions' => $dishData['porsi_kecil'] + $dishData['porsi_besar']
            ];
        }
        $menu->dishes()->sync($syncData);

        return redirect()->route('menus.index')->with('success', 'Menu harian berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu harian berhasil dihapus.');
    }

    public function getSppgPortions(\App\Models\Sppg $sppg)
    {
        $groups = \App\Models\BeneficiaryGroup::where('sppg_id', $sppg->id)->get();
        
        return response()->json([
            'porsi_kecil' => $groups->sum('porsi_kecil'),
            'porsi_besar' => $groups->sum('porsi_besar'),
        ]);
    }
}
