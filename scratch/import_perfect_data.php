<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Sppg;
use App\Models\BeneficiaryGroup;

// Clear current records to start fresh with perfect data
BeneficiaryGroup::query()->delete();

$sppg = Sppg::where('name', 'like', '%Karang Rejo%')->first();

if (!$sppg) {
    $sppg = Sppg::create(['name' => 'SPPG Karang Rejo Gunung Maligas', 'address' => 'Gunung Maligas']);
}

$schools = [
    [
        'name' => 'SD 095560 Karang Sari',
        'type' => 'sekolah',
        'count_siswa' => 154,
        'count_guru' => 10,
        'location' => 'Karang Sari, Gunung Maligas'
    ],
    [
        'name' => 'SD 091262 Karang Sari',
        'type' => 'sekolah',
        'count_siswa' => 210,
        'count_guru' => 18,
        'location' => 'Karang Sari, Gunung Maligas'
    ],
    [
        'name' => 'SDN 096780 Kampung Tape',
        'type' => 'sekolah',
        'count_siswa' => 165,
        'count_guru' => 10,
        'location' => 'Kampung Tape, Gunung Maligas'
    ],
    [
        'name' => 'SMP N 1 MALIGAS',
        'type' => 'sekolah',
        'count_siswa' => 385,
        'count_guru' => 26,
        'location' => 'Gunung Maligas'
    ],
    [
        'name' => 'MIS AL FIKRI',
        'type' => 'sekolah',
        'count_siswa' => 101,
        'count_guru' => 12,
        'location' => 'Gunung Maligas'
    ],
    [
        'name' => 'MIN 1 SUMALUNGUN',
        'type' => 'sekolah',
        'count_siswa' => 371,
        'count_guru' => 31,
        'location' => 'Simalungun'
    ],
    [
        'name' => 'PAUD/TK AL-RIDHO',
        'type' => 'sekolah',
        'count_siswa' => 58,
        'count_guru' => 6,
        'location' => 'Gunung Maligas'
    ],
    [
        'name' => 'SMP SATRYA BUDI',
        'type' => 'sekolah',
        'count_siswa' => 181,
        'count_guru' => 13,
        'location' => 'Gunung Maligas'
    ],
    [
        'name' => 'SDN 097806 KARANG SARI',
        'type' => 'sekolah',
        'count_siswa' => 94,
        'count_guru' => 9,
        'location' => 'Karang Sari, Gunung Maligas'
    ],
    [
        'name' => 'YAYASAN MAS BINAUL IMAN KARANG REJO',
        'type' => 'sekolah',
        'count_siswa' => 180,
        'count_guru' => 24,
        'location' => 'Karang Rejo'
    ],
    [
        'name' => 'MTS BINAUL IMAN KARANG REJO',
        'type' => 'sekolah',
        'count_siswa' => 240,
        'count_guru' => 21,
        'location' => 'Karang Rejo'
    ],
    [
        'name' => 'B3 KARANG REJO',
        'type' => 'posyandu',
        'count_hamil' => 34,
        'count_menyusui' => 80,
        'count_balita' => 86,
        'location' => 'Karang Rejo'
    ],
];

foreach ($schools as $s) {
    BeneficiaryGroup::create(array_merge($s, [
        'sppg_id' => $sppg->id,
        'porsi_besar' => ($s['count_siswa'] ?? 0) + ($s['count_hamil'] ?? 0) + ($s['count_menyusui'] ?? 0),
        'porsi_kecil' => ($s['count_guru'] ?? 0) + ($s['count_balita'] ?? 0), // Adjust logic if needed
        'total_beneficiaries' => ($s['count_siswa'] ?? 0) + ($s['count_guru'] ?? 0) + ($s['count_hamil'] ?? 0) + ($s['count_menyusui'] ?? 0) + ($s['count_balita'] ?? 0)
    ]));
}

echo "Perfect data imported successfully.\n";
