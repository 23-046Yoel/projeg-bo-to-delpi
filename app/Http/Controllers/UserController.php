<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sppg;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('sppg')->latest()->paginate(20);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $sppgs = Sppg::all();
        $roles = [
            User::ROLE_ADMIN => 'MASTER ADMIN',
            User::ROLE_KA_SPPG => 'KA SPPG',
            User::ROLE_PENGAWAS_GIZI => 'PENGAWAS GIZI',
            User::ROLE_PENGAWAS_KEUANGAN => 'PENGAWAS KEUANGAN',
            User::ROLE_ASLAP => 'ASISTEN LAPANGAN',
            User::ROLE_WAREHOUSE => 'STAF GUDANG',
            User::ROLE_QC => 'QUALITY CONTROL',
            User::ROLE_DRIVER => 'DRIVER OPERASIONAL',
            User::ROLE_VOLUNTEER => 'RELAWAN / PUBLIK',
        ];
        return view('users.create', compact('sppgs', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'role' => 'required|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
        ]);

        // Normalisasi nomor telepon
        $phone = preg_replace('/[^0-9]/', '', $validated['phone']);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }
        $validated['phone'] = $phone;

        // Auto-generate email jika kosong
        if (empty($validated['email'])) {
            $validated['email'] = $phone . '@aladelphi.or.id';
        }

        // Auto-generate password (tidak dipakai login WA tapi wajib ada di DB)
        $validated['password'] = bcrypt($phone . 'boto2024');

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Staff baru berhasil didaftarkan.');
    }

    public function edit(User $user)
    {
        $sppgs = Sppg::all();
        $roles = [
            User::ROLE_ADMIN => 'MASTER ADMIN',
            User::ROLE_KA_SPPG => 'KA SPPG',
            User::ROLE_PENGAWAS_GIZI => 'PENGAWAS GIZI',
            User::ROLE_PENGAWAS_KEUANGAN => 'PENGAWAS KEUANGAN',
            User::ROLE_ASLAP => 'ASISTEN LAPANGAN',
            User::ROLE_WAREHOUSE => 'STAF GUDANG',
            User::ROLE_QC => 'QUALITY CONTROL',
            User::ROLE_DRIVER => 'DRIVER OPERASIONAL',
            User::ROLE_VOLUNTEER => 'RELAWAN / PUBLIK',
        ];
        return view('users.edit', compact('user', 'sppgs', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
        ]);

        // Normalisasi nomor telepon
        $phone = preg_replace('/[^0-9]/', '', $validated['phone']);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }
        $validated['phone'] = $phone;

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Data staff berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus diri sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Staff berhasil dihapus.');
    }
}
