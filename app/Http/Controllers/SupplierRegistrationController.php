<?php

namespace App\Http\Controllers;

use App\Models\Sppg;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierRegistrationController extends Controller
{
    public function index()
    {
        $sppgs = Sppg::all();
        return view('suppliers.register', compact('sppgs'));
    }

    public function store(Request $request)
    {
        // 1. Normalisasi nomor telepon
        $phone = preg_replace('/[^0-9]/', '', $request->phone);
        if (str_starts_with($phone, '620')) {
            $phone = '62' . substr($phone, 3);
        } elseif (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        // Simpan versi ter-normalisasi ke request sebelum validasi
        $request->merge(['phone' => $phone]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'items' => 'required|string',
            'sppg_id' => 'nullable|exists:sppgs,id',
        ]);

        // 2. Cek apakah nomor HP sudah terdaftar di suppliers atau users (menggunakan pencocokan akhiran 9 digit terakhir untuk menghindari perbedaan format 08/62)
        $phoneSuffix = substr($phone, -9);
        $existsInSuppliers = Supplier::where('phone', 'like', '%' . $phoneSuffix)->exists();
        $existsInUsers = \App\Models\User::where('phone', 'like', '%' . $phoneSuffix)->exists();

        if ($existsInSuppliers || $existsInUsers) {
            $errMsg = 'Nomor HP/WhatsApp ini sudah terdaftar di sistem.';
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errMsg
                ], 422);
            }
            return back()->withInput()->withErrors(['phone' => $errMsg]);
        }

        // 3. Simpan data pemasok
        $supplier = Supplier::create($validated);

        // 4. Auto-create User account
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'phone' => $phone,
            'email' => $phone . '@aladelphi.or.id',
            'role' => \App\Models\User::ROLE_PEMASOK,
            'password' => bcrypt($phone . 'boto2024'),
            'sppg_id' => $validated['sppg_id'] ?? null,
        ]);

        // 5. Kirim Notifikasi WA via WhatsAppService
        $wa = app(\App\Services\WhatsAppService::class);
        $sppgName = $supplier->sppg ? $supplier->sppg->name : 'Master Office';

        // A. Pesan untuk Pemasok
        $msgForSupplier = "*[Pendaftaran Pemasok Berhasil]*\n\n" .
                          "Halo *{$supplier->name}*! 👋\n\n" .
                          "Pendaftaran Anda sebagai pemasok resmi di *MBG Foundation Hub (Alad Delphi)* telah berhasil disimpan.\n\n" .
                          "Anda sekarang dapat login ke dashboard sistem menggunakan nomor WhatsApp Anda ini untuk mengajukan penawaran bahan makanan secara berkala.\n\n" .
                          "Terima kasih atas kerjasamanya! 🙏";
        $wa->sendMessage($phone, $msgForSupplier);

        // B. Pesan untuk Admin
        $adminNumber = env('ADMIN_NOTIFICATION_NUMBER', '6285353325352');
        if ($adminNumber) {
            $msgForAdmin = "*[Notifikasi Pemasok Baru]*\n\n" .
                           "👤 *Nama:* {$supplier->name}\n" .
                           "📱 *No. HP:* +{$phone}\n" .
                           "📍 *Alamat/Desa:* {$supplier->village}\n" .
                           "🏢 *Dapur SPPG:* {$sppgName}\n" .
                           "📦 *Komoditas:* {$supplier->items}\n\n" .
                           "Sistem telah otomatis membuatkan akun user dengan role *Pemasok*.";
            $wa->sendMessage($adminNumber, $msgForAdmin);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil!'
            ]);
        }

        return back()->with('success', 'Pendaftaran berhasil! Kami akan menghubungi Anda segera.');
    }
}
