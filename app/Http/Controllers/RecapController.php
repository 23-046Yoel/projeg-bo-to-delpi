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
        $user = auth()->user();
        $startDate = $request->input('start_date', $request->input('date', date('Y-m-d')));
        $endDate = $request->input('end_date', $startDate);

        // Scoping: admin bisa filter manual, non-admin auto ke SPPG sendiri
        if ($user->isAdmin()) {
            $sppgId = $request->input('sppg_id', null);
        } else {
            $sppgId = $user->sppg_id;
        }

        $paymentQuery = Payment::query();
        $logQuery = MaterialLog::with('material');

        if ($sppgId) {
            $paymentQuery->where('sppg_id', $sppgId);
            $logQuery->where('sppg_id', $sppgId);
        }

        $totalIn = (clone $paymentQuery)->sum('amount_in');
        $totalOut = (clone $paymentQuery)->sum('amount_out');
        $currentBalance = (clone $paymentQuery)->orderBy('id', 'desc')->value('balance') ?? 0;

        $payments = (clone $paymentQuery)->whereBetween('date', [$startDate, $endDate])->get();
        $logs = $logQuery->whereBetween('date', [$startDate, $endDate])->get();

        $payments_total = $payments->where('amount_out', '>', 0)->sum('amount_out');
        $payments_count = $payments->count();
        $logs_in = $logs->where('type', 'in')->count();
        $logs_out = $logs->where('type', 'out')->count();
        
        $menuQuery = \App\Models\Menu::with('dishes.recipes.material')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date');

        if ($sppgId) {
            $menuQuery->where('sppg_id', $sppgId);
        }

        $menus = $menuQuery->get();
            
        $dist_count = \App\Models\MbgDistribution::whereBetween('distributed_at', [$startDate, $endDate])->sum('quantity');
        $orderQuery = \App\Models\Order::with('supplier', 'items.material')
            ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'received');

        if ($sppgId) {
            $orderQuery->where('sppg_id', $sppgId);
        }

        $received_orders = $orderQuery->get();

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
        $sppgs = $user->isAdmin() ? \App\Models\Sppg::all() : collect();

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
            'currentBalance',
            'sppgs',
            'sppgId'
        ));
    }
}
