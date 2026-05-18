<?php

namespace App\Http\Controllers;

use App\Models\MaterialLog;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MaterialLog::with(['material', 'sppg'])->latest();

        // 1. Scoping for non-admins
        if (auth()->check() && !auth()->user()->isAdmin() && auth()->user()->sppg_id) {
            $query->where('sppg_id', auth()->user()->sppg_id);
        }

        // 2. Filter by Kitchen (SPPG) for Admins
        if ($request->has('sppg_id') && $request->sppg_id != '') {
            $query->where('sppg_id', $request->sppg_id);
        }

        $logs = $query->paginate(15)->withQueryString();
        $sppgs = \App\Models\Sppg::all(); // For admin filter dropdown

        return view('material_logs.index', compact('logs', 'sppgs'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        
        // If user has no SPPG, show all materials (likely a master admin)
        // Otherwise only show materials belonging to their SPPG
        if ($user->sppg_id) {
            $materials = Material::where('sppg_id', $user->sppg_id)->get();
        } else {
            $materials = Material::all();
        }

        $prefilledMaterial = $request->query('material_name');
        return view('material_logs.create', compact('materials', 'prefilledMaterial'));
    }

    public function edit(MaterialLog $materialLog)
    {
        $materials = Material::all();
        return view('material_logs.edit', compact('materialLog', 'materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_name' => 'required|string|max:255',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:255',
        ]);

        $sppgId = auth()->user()->sppg_id;

        if ($request->type == 'out') {
            $material = Material::where('name', $request->material_name)
                                ->where('sppg_id', $sppgId)
                                ->first();
            $currentStock = $material ? $material->stock : 0;
            if ($currentStock < $request->quantity) {
                return back()->withErrors([
                    'quantity' => "Stok tidak mencukupi! Stok saat ini untuk {$request->material_name} adalah " . number_format($currentStock, 2) . " " . ($material->unit ?? 'Unit') . "."
                ])->withInput();
            }
        }

        DB::transaction(function () use ($request, $sppgId) {
            $material = Material::firstOrCreate(
                ['name' => $request->material_name, 'sppg_id' => $sppgId],
                ['type' => 'raw', 'stock' => 0]
            );

            $log = MaterialLog::create([
                'material_id' => $material->id,
                'sppg_id' => $sppgId,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'date' => $request->date,
                'notes' => $request->notes,
            ]);

            if ($request->type == 'in') {
                $material->increment('stock', $request->quantity);
            } else {
                $material->decrement('stock', $request->quantity);
            }
            
            $this->notifyStakeholders($log, 'DIBUAT', $request->material_name);
        });

        return redirect()->route('material_logs.index')->with('success', 'Log recorded and stock updated.');
    }

    public function update(Request $request, MaterialLog $materialLog)
    {
        $request->validate([
            'material_name' => 'required|string|max:255',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:255',
        ]);

        $material = $materialLog->material;
        
        $reversedStock = $material->stock;
        if ($materialLog->type == 'in') {
            $reversedStock -= $materialLog->quantity;
        } else {
            $reversedStock += $materialLog->quantity;
        }

        if ($request->type == 'out' && $reversedStock < $request->quantity) {
            return back()->withErrors([
                'quantity' => "Stok tidak mencukupi setelah penyesuaian! Stok setelah pembalikan transaksi lama adalah " . number_format($reversedStock, 2) . " " . ($material->unit ?? 'Unit') . "."
            ])->withInput();
        }

        if ($materialLog->type == 'in' && $reversedStock < 0) {
            return back()->withErrors([
                'quantity' => "Tidak dapat mengubah transaksi masuk ini karena stok saat ini akan menjadi negatif (" . number_format($reversedStock, 2) . " " . ($material->unit ?? 'Unit') . ")."
            ])->withInput();
        }

        DB::transaction(function () use ($request, $materialLog, $material) {
            // Reverse old impact
            if ($materialLog->type == 'in') {
                $material->decrement('stock', $materialLog->quantity);
            } else {
                $material->increment('stock', $materialLog->quantity);
            }

            // Apply new impact
            if ($request->type == 'in') {
                $material->increment('stock', $request->quantity);
            } else {
                $material->decrement('stock', $request->quantity);
            }

            $materialLog->update([
                'type' => $request->type,
                'quantity' => $request->quantity,
                'date' => $request->date,
                'notes' => $request->notes,
            ]);
            
            $this->notifyStakeholders($materialLog, 'DIUBAH', $material->name);
        });

        return redirect()->route('material_logs.index')->with('success', 'Log updated successfully.');
    }

    public function destroy(MaterialLog $materialLog)
    {
        $material = $materialLog->material;

        if ($materialLog->type == 'in' && $material->stock < $materialLog->quantity) {
            return back()->withErrors([
                'error' => "Tidak dapat menghapus transaksi masuk ini karena stok saat ini (" . number_format($material->stock, 2) . " " . ($material->unit ?? 'Unit') . ") lebih kecil dari jumlah transaksi yang akan dihapus (" . number_format($materialLog->quantity, 2) . " " . ($material->unit ?? 'Unit') . "). Stok tidak boleh negatif!"
            ]);
        }

        DB::transaction(function () use ($materialLog, $material) {
            // Reverse impact before deleting
            if ($materialLog->type == 'in') {
                $material->decrement('stock', $materialLog->quantity);
            } else {
                $material->increment('stock', $materialLog->quantity);
            }

            $this->notifyStakeholders($materialLog, 'DIHAPUS', $material->name);
            $materialLog->delete();
        });

        return redirect()->route('material_logs.index')->with('success', 'Log deleted successfully.');
    }

    protected function notifyStakeholders(MaterialLog $log, string $action, string $materialName)
    {
        try {
            // 1. Sync to Google Sheets
            if ($action !== 'DIHAPUS') {
                app(\App\Services\GoogleSheetService::class)->syncMaterialLog($log);
            }
            
            // 2. WhatsApp Notification
            $wa = app(\App\Services\WhatsAppService::class);
            $bot = app(\App\Services\BoToPersonalityService::class);
            $user = auth()->user();
            
            $msg = "*[LOG BAHAN SPPG]*\n" .
                   "--------------------------\n" .
                   "Status: *$action*\n" .
                   "Bahan: $materialName\n" .
                   "Tipe: " . ($log->type == 'in' ? 'MASUK (+)' : 'KELUAR (-)') . "\n" .
                   "Jumlah: " . number_format($log->quantity, 2) . "\n" .
                   "Oleh: {$user->name}\n" .
                   "--------------------------\n" .
                   "Laporan masuk dari Website, Bos!";

            $msgMedan = $bot->medanize($msg);

            // Notify all admins and finance for this SPPG
            $recipients = \App\Models\User::where('sppg_id', $log->sppg_id)
                ->whereIn('role', ['admin', 'finance'])
                ->get();

            foreach ($recipients as $recipient) {
                if ($recipient->phone) {
                    $wa->sendMessage($recipient->phone, $msgMedan);
                }
            }
            
            // Always send to master number backup
            $master = $wa->getMasterNumber();
            if ($master) {
                $wa->sendMessage($master, $msgMedan);
            }
            
        } catch (\Exception $e) {
            \Log::error("Failed to sync or notify log change: " . $e->getMessage());
        }
    }
}
