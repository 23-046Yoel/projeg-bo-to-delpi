<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\ProductionLog;
use App\Models\ProductionPreparation;
use App\Models\ProductionProcessing;
use App\Models\ProductionPortioning;
use App\Models\Sppg;
use App\Models\Dish;
use App\Models\Material;
use App\Models\BeneficiaryGroup;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductionController extends Controller
{
    // --- PREPARATION MODULE ---

    public function preparationIndex(Request $request)
    {
        $user = auth()->user();
        $query = Menu::with('sppg')->latest();

        if (!$user->isAdmin()) {
            $query->where('sppg_id', $user->sppg_id);
        }

        if ($request->filled('sppg_id')) {
            $query->where('sppg_id', $request->sppg_id);
        }

        $menus = $query->paginate(15);
        $sppgs = Sppg::orderBy('name')->get();

        return view('production.preparation.index', compact('menus', 'sppgs'));
    }

    public function preparationShow(Menu $menu)
    {
        $menu->load(['dishes.recipes.material', 'preparations.material', 'productionLog']);
        
        // Aggregate materials needed
        $materialsNeeded = [];
        foreach ($menu->dishes as $dish) {
            $portions = ($dish->pivot->porsi_besar + $dish->pivot->porsi_kecil) ?: $dish->pivot->portions;
            foreach ($dish->recipes as $recipe) {
                $matId = $recipe->material_id;
                if (!isset($materialsNeeded[$matId])) {
                    $materialsNeeded[$matId] = [
                        'material' => $recipe->material,
                        'estimated_qty' => 0,
                    ];
                }
                $materialsNeeded[$matId]['estimated_qty'] += $recipe->quantity * $portions;
            }
        }

        return view('production.preparation.show', compact('menu', 'materialsNeeded'));
    }

    public function preparationStore(Request $request, Menu $menu)
    {
        $request->validate([
            'prep_start' => 'nullable|date',
            'prep_end' => 'nullable|date',
            'items' => 'required|array',
        ]);

        // Update Overall Log only if times are provided
        if ($request->has('prep_start') || $request->has('prep_end')) {
            $logData = [];
            if ($request->has('prep_start')) $logData['prep_start'] = $request->prep_start;
            if ($request->has('prep_end')) $logData['prep_end'] = $request->prep_end;
            
            ProductionLog::updateOrCreate(
                ['menu_id' => $menu->id],
                $logData
            );
        }

        // Update/Create Per Material
        foreach ($request->items as $matId => $data) {
            $photoPath = null;
            if ($request->hasFile("items.$matId.photo")) {
                $photoPath = $request->file("items.$matId.photo")->store('production/preparation', 'public');
            }

            ProductionPreparation::updateOrCreate(
                ['menu_id' => $menu->id, 'material_id' => $matId],
                [
                    'qty_received' => $data['qty_received'] ?? 0,
                    'qty_prepared' => $data['qty_prepared'] ?? 0,
                    'qty_returned' => $data['qty_returned'] ?? 0,
                    'qty_waste' => $data['qty_waste'] ?? 0,
                    'start_time' => $data['start_time'] ?? null,
                    'end_time' => $data['end_time'] ?? null,
                    'photo' => $photoPath ?? ($menu->preparations()->where('material_id', $matId)->first()->photo ?? null),
                ]
            );
        }

        return redirect()->route('production.preparation.show', $menu)->with('success', 'Data Persiapan berhasil disimpan!');
    }

    // --- PROCESSING MODULE ---

    public function processingIndex(Request $request)
    {
        $user = auth()->user();
        $query = Menu::with('sppg')->latest();

        if (!$user->isAdmin()) {
            $query->where('sppg_id', $user->sppg_id);
        }

        if ($request->filled('sppg_id')) {
            $query->where('sppg_id', $request->sppg_id);
        }

        $menus = $query->paginate(15);
        $sppgs = Sppg::orderBy('name')->get();

        return view('production.processing.index', compact('menus', 'sppgs'));
    }

    public function processingShow(Menu $menu)
    {
        $menu->load(['dishes', 'processings.dish', 'productionLog']);
        return view('production.processing.show', compact('menu'));
    }

    public function processingStore(Request $request, Menu $menu)
    {
        $request->validate([
            'proc_start' => 'nullable|date',
            'proc_end' => 'nullable|date',
            'items' => 'required|array',
        ]);

        // Update Overall Log only if times are provided
        if ($request->has('proc_start') || $request->has('proc_end')) {
            $logData = [];
            if ($request->has('proc_start')) $logData['proc_start'] = $request->proc_start;
            if ($request->has('proc_end')) $logData['proc_end'] = $request->proc_end;

            ProductionLog::updateOrCreate(
                ['menu_id' => $menu->id],
                $logData
            );
        }

        // Update/Create Per Dish
        foreach ($request->items as $dishId => $data) {
            $photoPath = null;
            if ($request->hasFile("items.$dishId.boiling_temp_photo")) {
                $photoPath = $request->file("items.$dishId.boiling_temp_photo")->store('production/processing', 'public');
            }

            ProductionProcessing::updateOrCreate(
                ['menu_id' => $menu->id, 'dish_id' => $dishId],
                [
                    'qty_received' => $data['qty_received'] ?? 0,
                    'batch_count' => $data['batch_count'] ?? 1,
                    'weight_per_batch' => $data['weight_per_batch'] ?? 0,
                    'start_time' => $data['start_time'] ?? null,
                    'end_time' => $data['end_time'] ?? null,
                    'boiling_temp_photo' => $photoPath ?? ($menu->processings()->where('dish_id', $dishId)->first()->boiling_temp_photo ?? null),
                    'qty_produced' => $data['qty_produced'] ?? 0,
                ]
            );
        }

        return redirect()->route('production.processing.show', $menu)->with('success', 'Data Pengolahan berhasil disimpan!');
    }

    // --- PORTIONING MODULE ---

    public function portioningIndex(Request $request)
    {
        $user = auth()->user();
        $query = Menu::with('sppg')->latest();

        if (!$user->isAdmin()) {
            $query->where('sppg_id', $user->sppg_id);
        }

        if ($request->filled('sppg_id')) {
            $query->where('sppg_id', $request->sppg_id);
        }

        $menus = $query->paginate(15);
        $sppgs = Sppg::orderBy('name')->get();

        return view('production.portioning.index', compact('menus', 'sppgs'));
    }

    public function portioningShow(Menu $menu)
    {
        $menu->load(['sppg.beneficiaryGroups', 'portionings.beneficiaryGroup', 'productionLog']);
        return view('production.portioning.show', compact('menu'));
    }

    public function portioningStore(Request $request, Menu $menu)
    {
        $request->validate([
            'port_start' => 'nullable|date',
            'port_end' => 'nullable|date',
            'port_all_photo' => 'nullable|image',
            'items' => 'required|array',
        ]);

        // Update Overall Log
        if ($request->has('port_start') || $request->has('port_end') || $request->hasFile('port_all_photo')) {
            $logData = [];
            if ($request->has('port_start')) $logData['port_start'] = $request->port_start;
            if ($request->has('port_end')) $logData['port_end'] = $request->port_end;
            if ($request->hasFile('port_all_photo')) {
                $logData['port_all_photo'] = $request->file('port_all_photo')->store('production/portioning', 'public');
            }

            ProductionLog::updateOrCreate(
                ['menu_id' => $menu->id],
                $logData
            );
        }

        // Update/Create Per Beneficiary Group
        foreach ($request->items as $groupId => $data) {
            $photoPath = null;
            if ($request->hasFile("items.$groupId.ompreng_photo")) {
                $photoPath = $request->file("items.$groupId.ompreng_photo")->store('production/portioning', 'public');
            }

            ProductionPortioning::updateOrCreate(
                ['menu_id' => $menu->id, 'beneficiary_group_id' => $groupId],
                [
                    'qty_received' => $data['qty_received'] ?? 0,
                    'start_time' => $data['start_time'] ?? null,
                    'end_time' => $data['end_time'] ?? null,
                    'initial_temp' => $data['initial_temp'] ?? null,
                    'ompreng_photo' => $photoPath ?? ($menu->portionings()->where('beneficiary_group_id', $groupId)->first()->ompreng_photo ?? null),
                    'organoleptic_test' => $data['organoleptic_test'] ?? null,
                ]
            );
        }

        return redirect()->route('production.portioning.show', $menu)->with('success', 'Data Pemorsian berhasil disimpan!');
    }
}
