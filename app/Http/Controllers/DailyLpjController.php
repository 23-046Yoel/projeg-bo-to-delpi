<?php

namespace App\Http\Controllers;

use App\Models\DailyLpj;
use App\Models\Menu;
use App\Models\Sppg;
use App\Models\Payment;
use App\Models\MaterialLog;
use App\Models\MbgDistribution;
use App\Models\ProductionPreparation;
use App\Models\ProductionProcessing;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DailyLpjController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = DailyLpj::with(['menu', 'sppg'])->latest();

        if (!$user->isAdmin()) {
            $query->where('sppg_id', $user->sppg_id);
        }

        if ($request->filled('sppg_id')) {
            $query->where('sppg_id', $request->sppg_id);
        }

        $lpjs = $query->paginate(15);
        $sppgs = Sppg::orderBy('name')->get();

        return view('production.daily_lpj.index', compact('lpjs', 'sppgs'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $sppgId = $request->input('sppg_id', $user->sppg_id);
        $date = $request->input('date', date('Y-m-d'));

        $menu = Menu::with(['dishes.pivot', 'sppg'])
            ->where('sppg_id', $sppgId)
            ->where('date', $date)
            ->first();

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu untuk tanggal dan SPPG ini belum dibuat.');
        }

        // PRE-FILL DATA
        $sppg = Sppg::find($sppgId);
        
        // 1. Ringkasan
        $totalProduction = DB::table('production_processings')->where('menu_id', $menu->id)->sum('qty_produced');
        $totalDistribution = MbgDistribution::where('sppg_id', $sppgId)->whereDate('distributed_at', $date)->sum('quantity');
        
        // 2. Material Receipts
        $materialReceipts = MaterialLog::with('material')
            ->where('sppg_id', $sppgId)
            ->where('date', $date)
            ->where('type', 'in')
            ->get()
            ->map(function($log) {
                return [
                    'name' => $log->material->name,
                    'qty' => $log->quantity,
                    'unit' => $log->material->unit,
                    'organoleptic' => 'Baik',
                    'conclusion' => 'Diterima'
                ];
            })->toArray();

        // 3. HACCP Persiapan
        $haccpPreparation = ProductionPreparation::with('material')
            ->where('menu_id', $menu->id)
            ->get()
            ->map(function($prep) {
                return [
                    'material' => $prep->material->name,
                    'qty_received' => $prep->qty_received,
                    'qty_result' => $prep->qty_prepared,
                    'start_time' => $prep->start_time ? Carbon::parse($prep->start_time)->format('H:i') : '-',
                    'end_time' => $prep->end_time ? Carbon::parse($prep->end_time)->format('H:i') : '-',
                ];
            })->toArray();

        // 4. HACCP Pengolahan
        $haccpProcessing = ProductionProcessing::with('dish')
            ->where('menu_id', $menu->id)
            ->get()
            ->map(function($proc) {
                return [
                    'dish' => $proc->dish->name,
                    'qty_received' => $proc->qty_received,
                    'qty_result' => $proc->qty_produced,
                    'start_time' => $proc->start_time ? Carbon::parse($proc->start_time)->format('H:i') : '-',
                    'end_time' => $proc->end_time ? Carbon::parse($proc->end_time)->format('H:i') : '-',
                ];
            })->toArray();

        // 5. Distribusi
        $distributionData = MbgDistribution::with('beneficiary')
            ->where('sppg_id', $sppgId)
            ->whereDate('distributed_at', $date)
            ->get()
            ->map(function($dist) {
                return [
                    'beneficiary' => $dist->beneficiary->name,
                    'qty' => $dist->quantity,
                    'arrival_time' => $dist->distributed_at ? Carbon::parse($dist->distributed_at)->format('H:i') : '-',
                    'organoleptic' => 'Baik',
                    'bast' => 'Ada'
                ];
            })->toArray();

        // 6. Keuangan
        $initialBalance = Payment::where('sppg_id', $sppgId)
            ->where('date', '<', $date)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->value('balance') ?? 0;

        $expMaterials = Payment::where('sppg_id', $sppgId)
            ->where('date', $date)
            ->where('transaction_type', 'Biaya Bahan Baku')
            ->sum('amount_out');

        $expOpsSalary = Payment::where('sppg_id', $sppgId)
            ->where('date', $date)
            ->where('transaction_type', 'Biaya Operasional')
            ->where('description', 'like', '%Gaji%')
            ->sum('amount_out');

        $expOpsGas = Payment::where('sppg_id', $sppgId)
            ->where('date', $date)
            ->where('transaction_type', 'Biaya Operasional')
            ->where('description', 'like', '%Gas%')
            ->sum('amount_out');

        $expOpsElec = Payment::where('sppg_id', $sppgId)
            ->where('date', $date)
            ->where('transaction_type', 'Biaya Operasional')
            ->where('description', 'like', '%Listrik%')
            ->sum('amount_out');

        $expOpsAdmin = Payment::where('sppg_id', $sppgId)
            ->where('date', $date)
            ->where('transaction_type', 'Biaya Operasional')
            ->where(function($q) {
                $q->where('description', 'like', '%Admin%')
                  ->orWhere('description', 'like', '%ATK%');
            })->sum('amount_out');

        $expIncentive = Payment::where('sppg_id', $sppgId)
            ->where('date', $date)
            ->where('transaction_type', 'Insentif Fasilitas')
            ->sum('amount_out');

        $finalBalance = Payment::where('sppg_id', $sppgId)
            ->where('date', $date)
            ->orderBy('id', 'desc')
            ->value('balance') ?? $initialBalance;

        $data = [
            'menu_id' => $menu->id,
            'sppg_id' => $sppgId,
            'date' => $date,
            'sppg_name' => $sppg->name,
            'total_production' => $totalProduction,
            'total_distribution' => $totalDistribution,
            'leftover_food' => max(0, $totalProduction - $totalDistribution),
            'food_waste' => 0,
            'total_expenditure' => $expMaterials + $expOpsSalary + $expOpsGas + $expOpsElec + $expOpsAdmin + $expIncentive,
            'material_receipts' => $materialReceipts,
            'haccp_preparation' => $haccpPreparation,
            'haccp_processing' => $haccpProcessing,
            'distribution_data' => $distributionData,
            'initial_balance_virtual' => $initialBalance,
            'expenditure_materials_virtual' => $expMaterials,
            'expenditure_ops_salary_virtual' => $expOpsSalary,
            'expenditure_ops_gas_virtual' => $expOpsGas,
            'expenditure_ops_electricity_virtual' => $expOpsElec,
            'expenditure_ops_admin_virtual' => $expOpsAdmin,
            'expenditure_incentive_virtual' => $expIncentive,
            'final_balance_virtual' => $finalBalance,
            'conclusion' => 'Distribusi berjalan normal, tidak ada kejadian menonjol.',
            'signatures' => [
                'kepala_sppg' => $sppg->head_name ?? $user->name,
                'pengawas_gizi' => 'Lestari Ginting',
                'pengawas_keuangan' => 'Agita Sebayang',
                'asisten_lapangan' => 'Yoel Surbakti',
                'perwakilan_yayasan' => 'Silverius Bangun'
            ]
        ];

        return view('production.daily_lpj.create', compact('data', 'menu'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'sppg_id' => 'required|exists:sppgs,id',
            'date' => 'required|date',
            'total_production' => 'required|numeric',
            'total_distribution' => 'required|numeric',
            'leftover_food' => 'required|numeric',
            'food_waste' => 'required|numeric',
            'total_expenditure' => 'required|numeric',
            'material_receipts' => 'nullable|array',
            'haccp_preparation' => 'nullable|array',
            'haccp_processing' => 'nullable|array',
            'distribution_data' => 'nullable|array',
            'initial_balance_virtual' => 'required|numeric',
            'initial_balance_cash' => 'required|numeric',
            'expenditure_materials_virtual' => 'required|numeric',
            'expenditure_materials_cash' => 'required|numeric',
            'expenditure_ops_salary_virtual' => 'required|numeric',
            'expenditure_ops_salary_cash' => 'required|numeric',
            'expenditure_ops_gas_virtual' => 'required|numeric',
            'expenditure_ops_gas_cash' => 'required|numeric',
            'expenditure_ops_electricity_virtual' => 'required|numeric',
            'expenditure_ops_electricity_cash' => 'required|numeric',
            'expenditure_ops_admin_virtual' => 'required|numeric',
            'expenditure_ops_admin_cash' => 'required|numeric',
            'expenditure_incentive_virtual' => 'required|numeric',
            'expenditure_incentive_cash' => 'required|numeric',
            'final_balance_virtual' => 'required|numeric',
            'final_balance_cash' => 'required|numeric',
            'conclusion' => 'nullable|string',
            'signatures' => 'nullable|array',
        ]);

        DailyLpj::create($validated);

        return redirect()->route('production.daily-lpj.index')->with('success', 'LPJ Harian berhasil disimpan!');
    }

    public function show(DailyLpj $dailyLpj)
    {
        $dailyLpj->load(['menu.dishes', 'sppg']);
        return view('production.daily_lpj.show', compact('dailyLpj'));
    }

    public function edit(DailyLpj $dailyLpj)
    {
        $dailyLpj->load(['menu', 'sppg']);
        return view('production.daily_lpj.edit', compact('dailyLpj'));
    }

    public function update(Request $request, DailyLpj $dailyLpj)
    {
        $validated = $request->validate([
            'total_production' => 'required|numeric',
            'total_distribution' => 'required|numeric',
            'leftover_food' => 'required|numeric',
            'food_waste' => 'required|numeric',
            'total_expenditure' => 'required|numeric',
            'material_receipts' => 'nullable|array',
            'haccp_preparation' => 'nullable|array',
            'haccp_processing' => 'nullable|array',
            'distribution_data' => 'nullable|array',
            'initial_balance_virtual' => 'required|numeric',
            'initial_balance_cash' => 'required|numeric',
            'expenditure_materials_virtual' => 'required|numeric',
            'expenditure_materials_cash' => 'required|numeric',
            'expenditure_ops_salary_virtual' => 'required|numeric',
            'expenditure_ops_salary_cash' => 'required|numeric',
            'expenditure_ops_gas_virtual' => 'required|numeric',
            'expenditure_ops_gas_cash' => 'required|numeric',
            'expenditure_ops_electricity_virtual' => 'required|numeric',
            'expenditure_ops_electricity_cash' => 'required|numeric',
            'expenditure_ops_admin_virtual' => 'required|numeric',
            'expenditure_ops_admin_cash' => 'required|numeric',
            'expenditure_incentive_virtual' => 'required|numeric',
            'expenditure_incentive_cash' => 'required|numeric',
            'final_balance_virtual' => 'required|numeric',
            'final_balance_cash' => 'required|numeric',
            'conclusion' => 'nullable|string',
            'signatures' => 'nullable|array',
        ]);

        $dailyLpj->update($validated);

        return redirect()->route('production.daily-lpj.index')->with('success', 'LPJ Harian berhasil diperbarui!');
    }

    public function destroy(DailyLpj $dailyLpj)
    {
        $dailyLpj->delete();
        return redirect()->route('production.daily-lpj.index')->with('success', 'LPJ Harian berhasil dihapus!');
    }
}
