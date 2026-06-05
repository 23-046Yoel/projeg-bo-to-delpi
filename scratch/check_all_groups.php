<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$groups = \App\Models\BeneficiaryGroup::all();
echo "TOTAL GROUPS IN DB: " . $groups->count() . "\n";
foreach ($groups as $g) {
    $sppgName = $g->sppg ? $g->sppg->name : 'No SPPG';
    echo "ID: {$g->id} | Name: {$g->name} | SPPG ID: {$g->sppg_id} ({$sppgName}) | Total: {$g->total_beneficiaries} | Siswa: {$g->count_siswa} | Guru: {$g->count_guru} | Hamil: {$g->count_hamil} | Menyusui: {$g->count_menyusui} | Balita: {$g->count_balita}\n";
}
