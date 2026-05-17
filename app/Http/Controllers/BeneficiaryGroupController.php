<?php

namespace App\Http\Controllers;

use App\Models\BeneficiaryGroup;
use Illuminate\Http\Request;

class BeneficiaryGroupController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = BeneficiaryGroup::query()->where(function($q) {
            $q->where('total_beneficiaries', '>', 0)
              ->orWhere('porsi_besar', '>', 0)
              ->orWhere('porsi_kecil', '>', 0);
        });

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
            'category' => 'required|string',
            'porsi_besar' => 'nullable|integer|min:0',
            'porsi_kecil' => 'nullable|integer|min:0',
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

        // If portions are not provided, auto-calculate
        $porsiBesar = $request->porsi_besar ?? (($request->count_siswa ?? 0) + ($request->count_hamil ?? 0) + ($request->count_menyusui ?? 0));
        $porsiKecil = $request->porsi_kecil ?? (($request->count_guru ?? 0) + ($request->count_balita ?? 0));

        BeneficiaryGroup::create(array_merge($validated, [
            'sppg_id' => $sppg_id,
            'total_beneficiaries' => $total,
            'porsi_besar' => $porsiBesar,
            'porsi_kecil' => $porsiKecil,
        ]));

        return redirect()->route('beneficiary-groups.create')->with('success', 'Penerima Manfaat berhasil ditambahkan.');
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
            'category' => 'nullable|string',
            'porsi_besar' => 'nullable|integer|min:0',
            'porsi_kecil' => 'nullable|integer|min:0',
            'sppg_id' => 'nullable|exists:sppgs,id',
            'count_siswa' => 'nullable|integer|min:0',
            'count_guru' => 'nullable|integer|min:0',
            'count_hamil' => 'nullable|integer|min:0',
            'count_menyusui' => 'nullable|integer|min:0',
            'count_balita' => 'nullable|integer|min:0',
        ]);

        $countSiswa   = (int) ($request->count_siswa ?? 0);
        $countGuru    = (int) ($request->count_guru ?? 0);
        $countHamil   = (int) ($request->count_hamil ?? 0);
        $countMenyusui= (int) ($request->count_menyusui ?? 0);
        $countBalita  = (int) ($request->count_balita ?? 0);

        $porsiBesar = $request->filled('porsi_besar') ? (int)$request->porsi_besar : ($countSiswa + $countHamil + $countMenyusui);
        $porsiKecil = $request->filled('porsi_kecil') ? (int)$request->porsi_kecil : ($countGuru + $countBalita);

        $total = $countSiswa + $countGuru + $countHamil + $countMenyusui + $countBalita;
        // Jika semua count 0, gunakan porsi_besar + porsi_kecil sebagai total
        if ($total === 0) {
            $total = $porsiBesar + $porsiKecil;
        }

        $beneficiaryGroup->update(array_merge($validated, [
            'category'            => $request->category ?? ($request->type === 'posyandu' ? 'Posyandu' : 'Anak Sekolah'),
            'total_beneficiaries' => $total,
            'porsi_besar'         => $porsiBesar,
            'porsi_kecil'         => $porsiKecil,
            'count_siswa'         => $countSiswa,
            'count_guru'          => $countGuru,
            'count_hamil'         => $countHamil,
            'count_menyusui'      => $countMenyusui,
            'count_balita'        => $countBalita,
        ]));

        return redirect()->route('beneficiary-groups.index')->with('success', 'Penerima Manfaat berhasil diperbarui.');
    }

    public function destroy(BeneficiaryGroup $beneficiaryGroup)
    {
        $beneficiaryGroup->delete();
        return redirect()->route('beneficiary-groups.index')->with('success', 'Kelompok Penerima berhasil dihapus.');
    }
}
