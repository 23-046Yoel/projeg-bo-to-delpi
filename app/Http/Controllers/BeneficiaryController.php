<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Beneficiary::with('sppg');

        if (!auth()->user()->isAdmin() && auth()->user()->sppg_id) {
            $query->where('sppg_id', auth()->user()->sppg_id);
        } elseif ($request->filled('sppg_id')) {
            $query->where('sppg_id', $request->sppg_id);
        }

        $beneficiaries = $query->latest()->paginate(10);
        $sppgs = \App\Models\Sppg::orderBy('name')->get();
        return view('beneficiaries.index', compact('beneficiaries', 'sppgs'));
    }

    public function create()
    {
        $user = auth()->user();
        $sppgs = \App\Models\Sppg::all();
        // Admin dapat semua group agar bisa filter via JS per SPPG
        // Non-admin hanya dapat group SPPG mereka sendiri
        $groups = \App\Models\BeneficiaryGroup::when($user->sppg_id && !$user->isAdmin(), function($q) use ($user) {
            return $q->where('sppg_id', $user->sppg_id);
        })->with('sppg')->get();
        return view('beneficiaries.create', compact('groups', 'sppgs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beneficiary_group_id' => 'required|exists:beneficiary_groups,id',
            'sppg_id' => 'nullable|exists:sppgs,id',
            'category' => 'required|string|max:255',
            'parent_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:L,P',
            'dob' => 'nullable|date',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'allergies' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $group = \App\Models\BeneficiaryGroup::find($request->beneficiary_group_id);
        Beneficiary::create(array_merge($validated, [
            'sppg_id' => $validated['sppg_id'] ?? $group->sppg_id ?? auth()->user()->sppg_id,
            'origin' => $group->name
        ]));

        return redirect()->route('beneficiaries.index')->with('success', 'Penerima berhasil ditambahkan.');
    }

    public function show(Beneficiary $beneficiary)
    {
        return view('beneficiaries.show', compact('beneficiary'));
    }

    public function edit(Beneficiary $beneficiary)
    {
        $user = auth()->user();
        $sppgs = \App\Models\Sppg::all();
        $groups = \App\Models\BeneficiaryGroup::when($user->sppg_id && !$user->isAdmin(), function($q) use ($user) {
            return $q->where('sppg_id', $user->sppg_id);
        })->get();
        return view('beneficiaries.edit', compact('beneficiary', 'groups', 'sppgs'));
    }

    public function update(Request $request, Beneficiary $beneficiary)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beneficiary_group_id' => 'required|exists:beneficiary_groups,id',
            'category' => 'required|string|max:255',
            'parent_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:L,P',
            'dob' => 'nullable|date',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'allergies' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $beneficiary->update(array_merge($validated, [
            'origin' => \App\Models\BeneficiaryGroup::find($request->beneficiary_group_id)->name
        ]));

        return redirect()->route('beneficiaries.index')->with('success', 'Data penerima berhasil diperbarui.');
    }

    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();
        return redirect()->route('beneficiaries.index')->with('success', 'Penerima berhasil dihapus.');
    }
}
