<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: text/plain');

echo "=== SPPGS ===\n";
print_r(App\Models\Sppg::all(['id', 'name'])->toArray());

echo "\n=== ALL BENEFICIARY GROUPS ===\n";
foreach(App\Models\BeneficiaryGroup::all() as $bg) {
    echo "ID: {$bg->id} | Name: {$bg->name} | SPPG ID: {$bg->sppg_id} (Name: " . ($bg->sppg->name ?? 'None') . ") | Beneficiaries Count: " . $bg->beneficiaries()->count() . "\n";
}

echo "\n=== BENEFICIARIES COUNT ===\n";
echo "Total Beneficiaries in DB: " . App\Models\Beneficiary::count() . "\n";

echo "\n=== SAMPLE BENEFICIARIES ===\n";
foreach(App\Models\Beneficiary::limit(30)->get() as $b) {
    echo "Name: {$b->name} | SPPG ID: {$b->sppg_id} | Group ID: {$b->beneficiary_group_id}\n";
}
