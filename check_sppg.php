<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sppg;

echo "Checking SPPGs...\n";

$sppgs = Sppg::all();

foreach ($sppgs as $sppg) {
    echo "ID: {$sppg->id} | Name: {$sppg->name} | Lat: {$sppg->latitude} | Lon: {$sppg->longitude} | Radius: {$sppg->radius}\n";
}
