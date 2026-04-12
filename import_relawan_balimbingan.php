<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;

$spreadsheet = IOFactory::load('Data Relawan SPPG Balimbingan II.xlsx');
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

// Ambil info SPPG dari header
$sppgName = trim($rows[2][2] ?? 'SPPG Balimbingan II'); // Row 2, Col C

// Cari SPPG di database
$sppg = DB::table('sppgs')->where('name', 'LIKE', '%Balimbingan%')->first();
$sppgId = $sppg ? $sppg->id : null;

echo "====================================================\n";
echo "IMPORT DATA RELAWAN - SPPG Balimbingan II\n";
echo "====================================================\n";
echo "SPPG: $sppgName\n";
echo "SPPG ID di database: " . ($sppgId ?? 'TIDAK DITEMUKAN') . "\n\n";

$imported = 0;
$skipped  = 0;
$errors   = 0;

// Data mulai dari row index 8 (row 9 di Excel)
for ($i = 8; $i < count($rows); $i++) {
    $row = $rows[$i];

    $no    = trim($row[2] ?? '');
    $nama  = trim($row[3] ?? '');
    $nik   = trim($row[4] ?? '');
    $phone = trim($row[5] ?? '');
    $email = trim($row[7] ?? '');

    // Skip baris kosong
    if (empty($nama) || !is_numeric($no)) continue;

    // Normalisasi nomor HP
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (!empty($phone)) {
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }
    }

    // Buat email default jika kosong
    if (empty($email)) {
        $emailSlug = strtolower(str_replace(' ', '.', $nama));
        $email = $emailSlug . '@balimbingan.aladelphi.or.id';
    }

    // Cek apakah sudah ada (by phone atau email)
    $exists = false;
    if (!empty($phone)) {
        $exists = DB::table('users')->where('phone', $phone)->exists();
    }
    if (!$exists && !empty($email)) {
        $exists = DB::table('users')->where('email', $email)->exists();
    }

    if ($exists) {
        echo "  SKIP #$no: $nama (sudah ada)\n";
        $skipped++;
        continue;
    }

    try {
        DB::table('users')->insert([
            'name'       => $nama,
            'email'      => $email,
            'phone'      => $phone ?: null,
            'role'       => 'volunteer',
            'sppg_id'    => $sppgId,
            'password'   => Hash::make(uniqid('', true)), // dummy password, login via WA OTP
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "  ✅ #$no: $nama | HP: $phone | Email: $email\n";
        $imported++;
    } catch (Exception $e) {
        echo "  ❌ #$no: $nama | ERROR: " . $e->getMessage() . "\n";
        $errors++;
    }
}

echo "\n====================================================\n";
echo "SELESAI!\n";
echo "  ✅ Berhasil diimport : $imported relawan\n";
echo "  ⏭  Sudah ada (skip) : $skipped relawan\n";
echo "  ❌ Error             : $errors relawan\n";
echo "====================================================\n";
echo "\nSemua relawan bisa login dengan nomor WA masing-masing di https://aladelphi.or.id\n";
