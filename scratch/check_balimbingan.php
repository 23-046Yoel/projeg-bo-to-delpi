<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sppg = \App\Models\Sppg::where('name', 'like', '%Balimbingan%')->get();
foreach ($sppg as $s) {
    echo "SPPG: {$s->name} (ID: {$s->id})\n";
    $groups = \App\Models\BeneficiaryGroup::where('sppg_id', $s->id)->get();
    foreach ($groups as $g) {
        echo " - Group: {$g->name} (ID: {$g->id})\n";
        echo "   Type: {$g->type}, Category: {$g->category}\n";
        echo "   Siswa: {$g->count_siswa}, Guru: {$g->count_guru}, Hamil: {$g->count_hamil}, Menyusui: {$g->count_menyusui}, Balita: {$g->count_balita}\n";
        echo "   Porsi Besar: {$g->porsi_besar}, Porsi Kecil: {$g->porsi_kecil}\n";
        echo "   Total Beneficiaries: {$g->total_beneficiaries}\n";
    }
}
