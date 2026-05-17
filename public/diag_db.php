<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: text/plain');

echo "=== BENEFICIARY GROUP DETAIL ===\n";
print_r(App\Models\BeneficiaryGroup::where('sppg_id', 4)->get()->toArray());
