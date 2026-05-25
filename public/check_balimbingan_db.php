<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/plain');

$sppgs = \App\Models\Sppg::all();
foreach ($sppgs as $s) {
    echo "SPPG: {$s->name} (ID: {$s->id})\n";
    $groups = \App\Models\BeneficiaryGroup::where('sppg_id', $s->id)->get();
    echo "  Total Groups: " . $groups->count() . "\n";
    foreach ($groups as $g) {
        echo "   - ID: {$g->id} | Name: {$g->name} | Type: {$g->type}\n";
        echo "     Siswa: {$g->count_siswa} | Guru: {$g->count_guru} | Hamil: {$g->count_hamil} | Menyusui: {$g->count_menyusui} | Balita: {$g->count_balita}\n";
        echo "     Porsi Besar: {$g->porsi_besar} | Porsi Kecil: {$g->porsi_kecil}\n";
        echo "     Total: {$g->total_beneficiaries}\n";
    }
    echo "\n";
}
