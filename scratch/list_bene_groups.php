<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\BeneficiaryGroup;

echo "--- LIST BENE GROUPS ---\n";
foreach (BeneficiaryGroup::all() as $b) {
    if (str_contains(strtolower($b->name), 'aman') || str_contains(strtolower($b->name), 'sari') || str_contains(strtolower($b->name), 'dobana')) {
        echo "ID: {$b->id} | Name: {$b->name} | Lat: {$b->latitude} | Lng: {$b->longitude}\n";
    }
}
