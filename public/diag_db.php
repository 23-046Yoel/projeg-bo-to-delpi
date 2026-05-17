<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: text/plain');

echo "=== FIXING total_beneficiaries ===\n";
$groups = App\Models\BeneficiaryGroup::all();
$fixed = 0;
foreach ($groups as $group) {
    $total = ($group->porsi_besar ?? 0) + ($group->porsi_kecil ?? 0);
    if ($group->total_beneficiaries == 0 && $total > 0) {
        $group->total_beneficiaries = $total;
        $group->save();
        echo "Fixed: {$group->name} -> total_beneficiaries = {$total}\n";
        $fixed++;
    }
}

echo "\nTotal fixed: {$fixed} groups.\n";
echo "\n=== DONE ===\n";
