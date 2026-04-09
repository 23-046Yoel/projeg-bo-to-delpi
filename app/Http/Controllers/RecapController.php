<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\MaterialLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecapController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', $request->input('date', date('Y-m-d')));
        $endDate = $request->input('end_date', $startDate);
        $sppgId = auth()->user()->sppg_id;

        $totalIn = Payment::where('sppg_id', $sppgId)->sum('amount_in');
        $totalOut = Payment::where('sppg_id', $sppgId)->sum('amount_out');
        $currentBalance = Payment::where('sppg_id', $sppgId)->orderBy('id', 'desc')->value('balance') ?? 0;

        $payments = Payment::where('sppg_id', $sppgId)->whereBetween('date', [$startDate, $endDate])->get();
        $logs = MaterialLog::with('material')->where('sppg_id', $sppgId)->whereBetween('date', [$startDate, $endDate])->get();

        $payments_total = $payments->where('amount_out', '>', 0)->sum('amount_out');
        $payments_count = $payments->count();
        $logs_in = $logs->where('type', 'in')->count();
        $logs_out = $logs->where('type', 'out')->count();
        
        $menus = \App\Models\Menu::with('dishes.recipes.material')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get();
            
        $dist_count = \App\Models\MbgDistribution::whereBetween('distributed_at', [$startDate, $endDate])->sum('quantity');
        $received_orders = \App\Models\Order::with('supplier', 'items.material')
            ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'received')
            ->get();

        // Calculate total material requirement for all menus in range
        $requirements = [];
        foreach ($menus as $menu) {
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
        }

        $date = $startDate == $endDate ? $startDate : "$startDate to $endDate";

        return view('recap.index', compact(
            'startDate',
            'endDate',
            'date',
            'payments_total',
            'payments_count',
            'logs_in',
            'logs_out',
            'logs',
            'menus',
            'requirements',
            'dist_count',
            'received_orders',
            'totalIn',
            'totalOut',
            'currentBalance'
        ));
    }
}
