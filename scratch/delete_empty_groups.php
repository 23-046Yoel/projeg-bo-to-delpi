<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\BeneficiaryGroup;

// Delete old records that have NULL porsi_besar AND NULL porsi_kecil (old data without portions)
$deleted = BeneficiaryGroup::whereNull('porsi_besar')->whereNull('porsi_kecil')->delete();

echo "Deleted {$deleted} records with no portion data.\n";
echo "Remaining records: " . BeneficiaryGroup::count() . "\n";
