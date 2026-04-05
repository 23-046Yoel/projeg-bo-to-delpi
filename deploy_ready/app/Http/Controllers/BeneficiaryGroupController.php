<?php

namespace App\Http\Controllers;

use App\Models\BeneficiaryGroup;
use Illuminate\Http\Request;

class BeneficiaryGroupController extends Controller
{
    public function index()
    {
        $groups = BeneficiaryGroup::where('sppg_id', auth()->user()->sppg_id)->latest()->paginate(10);
        return view('beneficiary_groups.index', compact('groups'));
    }

    public function create()
    {
        return view('beneficiary_groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'total_beneficiaries' => 'nullable|integer|min:0',
        ]);

        BeneficiaryGroup::create(array_merge($validated, [
            'sppg_id' => auth()->user()->sppg_id
        ]));

        return redirect()->route('beneficiary-groups.index')->with('success', 'Kelompok Penerima (Sekolah) berhasil ditambahkan.');
    }

    public function edit(BeneficiaryGroup $beneficiaryGroup)
    {
        return view('beneficiary_groups.edit', compact('beneficiaryGroup'));
    }

    public function update(Request $request, BeneficiaryGroup $beneficiaryGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'total_beneficiaries' => 'nullable|integer|min:0',
        ]);

        $beneficiaryGroup->update($validated);

        return redirect()->route('beneficiary-groups.index')->with('success', 'Kelompok Penerima berhasil diperbarui.');
    }

    public function destroy(BeneficiaryGroup $beneficiaryGroup)
    {
        $beneficiaryGroup->delete();
        return redirect()->route('beneficiary-groups.index')->with('success', 'Kelompok Penerima berhasil dihapus.');
    }
}
