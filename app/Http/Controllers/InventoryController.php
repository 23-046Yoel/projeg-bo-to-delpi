<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        
        $materials = \App\Models\Material::all();
        $report = [];

        foreach ($materials as $mat) {
            $initialBalance = \App\Models\MaterialLog::where('material_id', $mat->id)
                ->where('date', '<', $startDate)
                ->sum(\Illuminate\Support\Facades\DB::raw("CASE WHEN type = 'in' THEN quantity ELSE -quantity END"));
                
            $logs = \App\Models\MaterialLog::where('material_id', $mat->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();        

            $masuk = $logs->where('type', 'in')->sum('quantity');
            $keluar = $logs->where('type', 'out')->sum('quantity');
            $saldoAkhir = $initialBalance + $masuk - $keluar;

            $report[] = [
                'name' => $mat->name,
                'saldo_awal' => $initialBalance,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'saldo_akhir' => $saldoAkhir
            ];
        }

        return view('inventory.index', compact('report', 'startDate', 'endDate'));
    }
}
