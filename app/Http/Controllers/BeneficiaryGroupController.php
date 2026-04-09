<?php

namespace App\Http\Controllers;

use App\Models\BeneficiaryGroup;
use Illuminate\Http\Request;

class BeneficiaryGroupController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = BeneficiaryGroup::query();

        // Admin can filter by SPPG
        if ($request->has('sppg_id') && $request->sppg_id != '') {
            $query->where('sppg_id', $request->sppg_id);
        } elseif ($user->sppg_id) {
            // Non-admin filtered by their assigned SPPG
            $query->where('sppg_id', $user->sppg_id);
        }

        $groups = $query->with('sppg')->latest()->paginate(20);
        $sppgs = \App\Models\Sppg::all();
        
        return view('beneficiary_groups.index', compact('groups', 'sppgs'));
    }

    public function create()
    {
        $user = auth()->user();
        $query = BeneficiaryGroup::query();

        if ($user->sppg_id) {
            $query->where('sppg_id', $user->sppg_id);
        }

        $groups = $query->with('sppg')->latest()->get();
        $sppgs = \App\Models\Sppg::all();
        return view('beneficiary_groups.create', compact('groups', 'sppgs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'type' => 'required|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
            'count_siswa' => 'nullable|integer|min:0',
            'count_guru' => 'nullable|integer|min:0',
            'count_hamil' => 'nullable|integer|min:0',
            'count_menyusui' => 'nullable|integer|min:0',
            'count_balita' => 'nullable|integer|min:0',
        ]);

        $sppg_id = $request->sppg_id ?? auth()->user()->sppg_id;

        $total = ($request->count_siswa ?? 0) + 
                 ($request->count_guru ?? 0) + 
                 ($request->count_hamil ?? 0) + 
                 ($request->count_menyusui ?? 0) + 
                 ($request->count_balita ?? 0);

        BeneficiaryGroup::create(array_merge($validated, [
            'sppg_id' => $sppg_id,
            'total_beneficiaries' => $total,
            // Automatically set portions if not manual
            'porsi_besar' => ($request->count_siswa ?? 0) + ($request->count_hamil ?? 0) + ($request->count_menyusui ?? 0),
            'porsi_kecil' => ($request->count_guru ?? 0) + ($request->count_balita ?? 0),
        ]));

        return redirect()->route('beneficiary-groups.index')->with('success', 'Penerima Manfaat berhasil ditambahkan.');
    }

    public function edit(BeneficiaryGroup $beneficiaryGroup)
    {
        $sppgs = \App\Models\Sppg::all();
        return view('beneficiary_groups.edit', compact('beneficiaryGroup', 'sppgs'));
    }

    public function update(Request $request, BeneficiaryGroup $beneficiaryGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'type' => 'required|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
            'count_siswa' => 'nullable|integer|min:0',
            'count_guru' => 'nullable|integer|min:0',
            'count_hamil' => 'nullable|integer|min:0',
            'count_menyusui' => 'nullable|integer|min:0',
            'count_balita' => 'nullable|integer|min:0',
        ]);

        $total = ($request->count_siswa ?? 0) + 
                 ($request->count_guru ?? 0) + 
                 ($request->count_hamil ?? 0) + 
                 ($request->count_menyusui ?? 0) + 
                 ($request->count_balita ?? 0);

        $beneficiaryGroup->update(array_merge($validated, [
            'total_beneficiaries' => $total,
            'porsi_besar' => ($request->count_siswa ?? 0) + ($request->count_hamil ?? 0) + ($request->count_menyusui ?? 0),
            'porsi_kecil' => ($request->count_guru ?? 0) + ($request->count_balita ?? 0),
        ]));

        return redirect()->route('beneficiary-groups.index')->with('success', 'Penerima Manfaat berhasil diperbarui.');
    }

    public function destroy(BeneficiaryGroup $beneficiaryGroup)
    {
        $beneficiaryGroup->delete();
        return redirect()->route('beneficiary-groups.index')->with('success', 'Kelompok Penerima berhasil dihapus.');
    }
}
