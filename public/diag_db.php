<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: text/plain');

echo "=== FIXING total_beneficiaries ===\n";
$groups = App\Models\BeneficiaryGroup::all();
$fixed = 0;
foreach ($groups as $group) {
    $porsiBesar = $group->porsi_besar ?? 0;
    $porsiKecil = $group->porsi_kecil ?? 0;
    $total = $porsiBesar + $porsiKecil;
    echo "Check: {$group->name} | porsi_besar={$porsiBesar} | porsi_kecil={$porsiKecil} | current total={$group->total_beneficiaries}\n";
    if ($group->total_beneficiaries == 0 && $total > 0) {
        \Illuminate\Support\Facades\DB::table('beneficiary_groups')
            ->where('id', $group->id)
            ->update(['total_beneficiaries' => $total]);
        echo "  --> FIXED! total_beneficiaries = {$total}\n";
        $fixed++;
    }
}

echo "\nTotal fixed: {$fixed} groups.\n";
echo "=== DONE ===\n";
