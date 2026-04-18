<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Sppg;

echo "--- UPDATING COORDINATES ---\n";

// Update Sppg Balimbingan II (ID: 4)
$s1 = Sppg::find(4);
if ($s1) {
    $s1->latitude = 2.8853232860565186;
    $s1->longitude = 99.16383361816406;
    $s1->save();
    echo "ID 4 (Balimbingan II) updated.\n";
} else {
    echo "ID 4 NOT FOUND.\n";
}

// Update Sppg Aman Sari Dobana (Mapping to ID 1: Dolok Batu Nanggar)
$s2 = Sppg::find(1);
if ($s2) {
    $s2->latitude = 3.111654043197632;
    $s2->longitude = 99.15019989013672;
    // Optionally update name/location if the user wants it more specific
    $s2->save();
    echo "ID 1 (Aman Sari Dobana) updated.\n";
} else {
    echo "ID 1 NOT FOUND.\n";
}
