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
                'id' => $mat->id,
                'name' => $mat->name,
                'unit' => $mat->unit,
                'saldo_awal' => $initialBalance,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'saldo_akhir' => $saldoAkhir
            ];
        }

        return view('inventory.index', compact('report', 'startDate', 'endDate', 'materials'));
    }

    public function adjust(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.01',
            'note' => 'nullable|string'
        ]);

        $material = \App\Models\Material::findOrFail($validated['material_id']);
        
        \App\Models\MaterialLog::create([
            'material_id' => $material->id,
            'sppg_id' => auth()->user()->sppg_id,
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'date' => now(),
            'notes' => $validated['note'] ?? 'Penyesuaian manual'
        ]);

        if ($validated['type'] === 'in') {
            $material->increment('stock', $validated['quantity']);
        } else {
            $material->decrement('stock', $validated['quantity']);
        }

        return redirect()->route('inventory.index')->with('success', 'Stok berhasil diperbarui.');
    }
}
