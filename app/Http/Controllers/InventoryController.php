<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());
        $search = $request->input('search');
        $sppgId = $request->input('sppg_id');
        
        $query = \App\Models\Material::query();
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($sppgId) {
            $query->where('sppg_id', $sppgId);
        }
        $materials = $query->get();
        $sppgs = \App\Models\Sppg::all();
        $report = [];

        foreach ($materials as $mat) {
            $initialBalanceQuery = \App\Models\MaterialLog::where('material_id', $mat->id)
                ->where('date', '<', $startDate);
            
            if ($sppgId) {
                $initialBalanceQuery->where('sppg_id', $sppgId);
            }

            $initialBalance = $initialBalanceQuery->sum(\Illuminate\Support\Facades\DB::raw("CASE WHEN type = 'in' THEN quantity ELSE -quantity END"));
                
            $logQuery = \App\Models\MaterialLog::where('material_id', $mat->id)
                ->whereBetween('date', [$startDate, $endDate]);

            if ($sppgId) {
                $logQuery->where('sppg_id', $sppgId);
            }

            $logs = $logQuery->get();        

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

        $recentLogsQuery = \App\Models\MaterialLog::with(['material', 'sppg'])
            ->orderBy('created_at', 'desc')
            ->limit(15);

        if ($sppgId) {
            $recentLogsQuery->where('sppg_id', $sppgId);
        }

        $recentLogs = $recentLogsQuery->get();

        return view('inventory.index', compact('report', 'startDate', 'endDate', 'materials', 'sppgs', 'search', 'sppgId', 'recentLogs'));
    }

    public function adjust(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'sppg_id' => 'required|exists:sppgs,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.01',
            'note' => 'nullable|string',
            'photo' => 'nullable|image|max:10240' // Max 10MB for camera photos
        ]);

        $material = \App\Models\Material::findOrFail($validated['material_id']);
        
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('material_logs', 'public');
        }

        \App\Models\MaterialLog::create([
            'material_id' => $material->id,
            'sppg_id' => $validated['sppg_id'],
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'date' => now(),
            'notes' => $validated['note'] ?? 'Penyesuaian manual',
            'photo_path' => $photoPath
        ]);

        // Sync stock column in materials table
        if ($validated['type'] === 'in') {
            $material->increment('stock', $validated['quantity']);
        } else {
            $material->decrement('stock', $validated['quantity']);
        }

        return redirect()->route('inventory.index', ['sppg_id' => $validated['sppg_id']])
            ->with('success', 'Stok berhasil diperbarui.');
    }
}
