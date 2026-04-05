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
    public function index()
    {
        $logs = MaterialLog::with('material')->latest()->paginate(15);
        return view('material_logs.index', compact('logs'));
    }

    public function create()
    {
        $materials = Material::all();
        return view('material_logs.create', compact('materials'));
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
        ]);

        $sppgId = auth()->user()->sppg_id;

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
        ]);

        DB::transaction(function () use ($request, $materialLog) {
            $material = $materialLog->material;
            
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
            ]);
            
            $this->notifyStakeholders($materialLog, 'DIUBAH', $material->name);
        });

        return redirect()->route('material_logs.index')->with('success', 'Log updated successfully.');
    }

    public function destroy(MaterialLog $materialLog)
    {
        DB::transaction(function () use ($materialLog) {
            $material = $materialLog->material;
            
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
