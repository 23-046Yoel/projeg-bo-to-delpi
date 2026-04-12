<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Sppg;
use App\Models\BeneficiaryGroup;

// Find SPPG Karang Rejo Gunung Maligas
$sppg = Sppg::where('name', 'like', '%Karang Rejo%')->first();

if (!$sppg) {
    // Create it if it doesn't exist
    $sppg = Sppg::create([
        'name' => 'SPPG Karang Rejo Gunung Maligas',
        'address' => 'Gunung Maligas, Simalungun',
    ]);
    echo "SPPG created with ID: {$sppg->id}\n";
} else {
    echo "Found SPPG: {$sppg->name} (ID: {$sppg->id})\n";
}

// School/Beneficiary Group data from PDF
$schools = [
    [
        'name'          => 'SD 095560 Karang Sari',
        'type'          => 'sekolah',
        'total_siswa'   => 154,
        'total_staff'   => 10,
        'porsi_besar'   => 154,
        'porsi_kecil'   => 10,
        'location'      => 'Karang Sari, Gunung Maligas',
    ],
    [
        'name'          => 'SD 091262 Karang Sari',
        'type'          => 'sekolah',
        'total_siswa'   => 210,
        'total_staff'   => 18,
        'porsi_besar'   => 210,
        'porsi_kecil'   => 18,
        'location'      => 'Karang Sari, Gunung Maligas',
    ],
    [
        'name'          => 'SDN 096780 Kampung Tape',
        'type'          => 'sekolah',
        'total_siswa'   => 165,
        'total_staff'   => 10,
        'porsi_besar'   => 165,
        'porsi_kecil'   => 10,
        'location'      => 'Kampung Tape, Gunung Maligas',
    ],
    [
        'name'          => 'SMP N 1 Maligas',
        'type'          => 'sekolah',
        'total_siswa'   => 385,
        'total_staff'   => 26,
        'porsi_besar'   => 385,
        'porsi_kecil'   => 26,
        'location'      => 'Gunung Maligas, Simalungun',
    ],
    [
        'name'          => 'MIS Al Fikri',
        'type'          => 'sekolah',
        'total_siswa'   => 101,
        'total_staff'   => 12,
        'porsi_besar'   => 101,
        'porsi_kecil'   => 12,
        'location'      => 'Gunung Maligas, Simalungun',
    ],
    [
        'name'          => 'MIN 1 Simalungun',
        'type'          => 'sekolah',
        'total_siswa'   => 371,
        'total_staff'   => 31,
        'porsi_besar'   => 371,
        'porsi_kecil'   => 31,
        'location'      => 'Simalungun',
    ],
    [
        'name'          => 'PAUD/TK Al-Ridho',
        'type'          => 'sekolah',
        'total_siswa'   => 58,
        'total_staff'   => 6,
        'porsi_besar'   => 58,
        'porsi_kecil'   => 6,
        'location'      => 'Gunung Maligas, Simalungun',
    ],
    [
        'name'          => 'SMP Satrya Budi',
        'type'          => 'sekolah',
        'total_siswa'   => 181,
        'total_staff'   => 13,
        'porsi_besar'   => 181,
        'porsi_kecil'   => 13,
        'location'      => 'Gunung Maligas, Simalungun',
    ],
    [
        'name'          => 'SDN 097806 Karang Sari',
        'type'          => 'sekolah',
        'total_siswa'   => 94,
        'total_staff'   => 9,
        'porsi_besar'   => 94,
        'porsi_kecil'   => 9,
        'location'      => 'Karang Sari, Gunung Maligas',
    ],
    [
        'name'          => 'Yayasan MAS Binaul Iman Karang Rejo',
        'type'          => 'sekolah',
        'total_siswa'   => 180,
        'total_staff'   => 24,
        'porsi_besar'   => 180,
        'porsi_kecil'   => 24,
        'location'      => 'Karang Rejo, Gunung Maligas',
    ],
    [
        'name'          => 'MTS Binaul Iman Karang Rejo',
        'type'          => 'sekolah',
        'total_siswa'   => 240,
        'total_staff'   => 21,
        'porsi_besar'   => 240,
        'porsi_kecil'   => 21,
        'location'      => 'Karang Rejo, Gunung Maligas',
    ],
    [
        'name'          => 'B3 Karang Rejo (Posyandu)',
        'type'          => 'posyandu',
        'total_siswa'   => 86,  // Balita
        'total_staff'   => 24,  // Ibu Hamil 34 + Ibu Menyusui 80 + staff 24
        'porsi_besar'   => 114, // Ibu Hamil 34 + Ibu Menyusui 80
        'porsi_kecil'   => 86,  // Balita
        'location'      => 'Karang Rejo, Gunung Maligas',
    ],
];

$imported = 0;
$skipped = 0;

foreach ($schools as $school) {
    $existing = BeneficiaryGroup::where('name', $school['name'])
        ->where('sppg_id', $sppg->id)
        ->first();

    if ($existing) {
        echo "  SKIP (sudah ada): {$school['name']}\n";
        $skipped++;
        continue;
    }

    $data = [
        'name'        => $school['name'],
        'sppg_id'     => $sppg->id,
        'location'    => $school['location'],
        'type'        => $school['type'] ?? 'sekolah',
        'porsi_besar' => $school['porsi_besar'] ?? null,
        'porsi_kecil' => $school['porsi_kecil'] ?? null,
    ];

    BeneficiaryGroup::create($data);
    echo "  IMPORTED: {$school['name']} | Siswa: {$school['total_siswa']} | Staff: {$school['total_staff']}\n";
    $imported++;
}

echo "\n---\n";
echo "Selesai! Berhasil diimpor: {$imported} | Dilewati (duplikat): {$skipped}\n";
echo "Total penerima manfaat: 2519 orang\n";
