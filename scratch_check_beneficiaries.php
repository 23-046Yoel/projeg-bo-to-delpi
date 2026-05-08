<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Beneficiary;
use App\Models\BeneficiaryGroup;

echo "Total Groups: " . BeneficiaryGroup::count() . "\n";
echo "Sum Total Beneficiaries: " . BeneficiaryGroup::sum('total_beneficiaries') . "\n";
echo "Total Individual Beneficiaries: " . Beneficiary::count() . "\n";
