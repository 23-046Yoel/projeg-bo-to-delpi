<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MaterialLog;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Order::with('supplier', 'items.material');
        
        if ($request->filled('date')) {
            $query->whereDate('order_date', $request->date);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $orders = $query->latest()->get();
        $suppliers = \App\Models\Supplier::orderBy('name')->get();

        return view('orders.index', compact('orders', 'suppliers'));
    }

    public function show(Order $order)
    {
        $order->load(['supplier', 'items.material']);
        return view('orders.show', compact('order'));
    }

    public function create(Request $request)
    {
        $suppliers = \App\Models\Supplier::all();
        $materials = \App\Models\Material::all()->map(function($material) {
            $lastItem = \App\Models\OrderItem::where('material_id', $material->id)
                ->whereHas('order', function($q) {
                    $q->where('status', '!=', 'pending');
                })
                ->latest()
                ->first();
            
            $material->last_price = $lastItem ? $lastItem->price : 0;
            return $material;
        });

        $prepopulatedItems = [];
        if ($request->has('menu_id') || ($request->has('start_date') && $request->has('end_date'))) {
            $query = \App\Models\Menu::with('dishes.recipes.material');
            
            if ($request->has('menu_id')) {
                $query->where('id', $request->menu_id);
            } else {
                $query->whereBetween('date', [$request->start_date, $request->end_date]);
            }
            
            $menus = $query->get();
            
            if ($menus->count() > 0) {
                $requirements = [];
                foreach ($menus as $menu) {
                    foreach ($menu->dishes as $dish) {
                        $portions = ($dish->pivot->porsi_besar + $dish->pivot->porsi_kecil) ?: $dish->pivot->portions;
                        foreach ($dish->recipes as $recipe) {
                            $matId = $recipe->material_id;
                            $needed = $recipe->quantity * $portions;
                            
                            if (!isset($requirements[$matId])) {
                                $requirements[$matId] = [
                                    'material_id' => $matId,
                                    'name' => $recipe->material->name,
                                    'quantity' => 0,
                                    'unit' => $recipe->unit,
                                    'price' => 0
                                ];
                                
                                // Get last price for this material
                                $lastPrice = \App\Models\OrderItem::where('material_id', $matId)
                                    ->whereHas('order', function($q) { $q->where('status', '!=', 'pending'); })
                                    ->latest()->value('price');
                                $requirements[$matId]['price'] = $lastPrice ?? 0;
                            }
                            $requirements[$matId]['quantity'] += $needed;
                        }
                    }
                }
                $prepopulatedItems = array_values($requirements);
            }
        }

        return view('orders.create', compact('suppliers', 'materials', 'prepopulatedItems'));
    }

    public function store(Request $request)
    {
        $order = \App\Models\Order::create([
            'supplier_id' => $request->supplier_id,
            'order_date' => $request->order_date,
            'status' => 'pending',
            'sppg_id' => auth()->user()->sppg_id
        ]);

        foreach ($request->items as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'material_id' => $item['material_id'],
                'requested_quantity' => $item['quantity'],
                'unit' => $item['unit'],
                'price' => $item['price'] ?? 0
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Surat Pesanan berhasil dibuat!');
    }

    public function dailyReport(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $user = auth()->user();

        $query = \App\Models\Menu::with(['dishes.recipes.material' => function($q) {
            $q->withTrashed();
        }])->where('date', $date);

        if (!$user->isAdmin()) {
            $query->where('sppg_id', $user->sppg_id);
        }

        $menus = $query->get();
        $requirements = [];

        foreach ($menus as $menu) {
            foreach ($menu->dishes as $dish) {
                $portions = ($dish->pivot->porsi_besar + $dish->pivot->porsi_kecil) ?: $dish->pivot->portions;
                foreach ($dish->recipes as $recipe) {
                    $matId = $recipe->material_id;
                    $needed = $recipe->quantity * $portions;

                    if (!isset($requirements[$matId])) {
                        $requirements[$matId] = [
                            'name' => $recipe->material->name ?? 'Bahan Terhapus',
                            'total' => 0,
                            'unit' => $recipe->unit,
                            'price' => \App\Models\OrderItem::where('material_id', $matId)
                                ->whereHas('order', function($q) { $q->where('status', '!=', 'pending'); })
                                ->latest()->value('price') ?? 0
                        ];
                    }
                    $requirements[$matId]['total'] += $needed;
                }
            }
        }

        // Sort by name
        uasort($requirements, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return view('orders.daily', compact('requirements', 'date'));
    }

    public function getRequirementsJson(Request $request)
    {
        $date = $request->get('date');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        if (!$date && (!$startDate || !$endDate)) {
            return response()->json([]);
        }

        $user = auth()->user();
        $query = \App\Models\Menu::with(['dishes.recipes.material']);
            
        if ($date) {
            $query->where('date', $date);
        } else {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        if (!$user->isAdmin()) {
            $query->where('sppg_id', $user->sppg_id);
        }

        $menus = $query->get();
        $requirements = [];

        foreach ($menus as $menu) {
            foreach ($menu->dishes as $dish) {
                // Gunakan penjumlahan porsi ganda atau porsi lama
                $portions = ($dish->pivot->porsi_besar + $dish->pivot->porsi_kecil) ?: $dish->pivot->portions;
                
                foreach ($dish->recipes as $recipe) {
                    $matId = $recipe->material_id;
                    $needed = $recipe->quantity * $portions;

                    if (!isset($requirements[$matId])) {
                        $requirements[$matId] = [
                            'material_id' => $matId,
                            'name' => $recipe->material->name ?? 'Unknown',
                            'quantity' => 0,
                            'unit' => $recipe->unit,
                            'price' => \App\Models\OrderItem::where('material_id', $matId)
                                ->whereHas('order', function($q) { $q->where('status', '!=', 'pending'); })
                                ->latest()->value('price') ?? 0
                        ];
                    }
                    $requirements[$matId]['quantity'] += $needed;
                }
            }
        }

        return response()->json(array_values($requirements));
    }

    public function receive(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'received']);
            
            foreach ($order->items as $item) {
                MaterialLog::create([
                    'material_id' => $item->material_id,
                    'sppg_id' => $order->sppg_id,
                    'type' => 'in',
                    'quantity' => $item->requested_quantity,
                    'date' => now(),
                ]);
                
                $item->material->increment('stock', $item->requested_quantity);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Barang telah diterima dan stok diperbarui!');
    }
}
