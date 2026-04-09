<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MaterialLog;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::with('supplier', 'items.material')->latest()->get();
        return view('orders.index', compact('orders'));
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
                        $portions = $dish->pivot->portions;
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
