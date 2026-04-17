<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sppg;

echo "Updating SPPG Karang Rejo location and radius...\n";

// Find SPPG by name or location
$sppg = Sppg::where('name', 'like', '%Karang Rejo%')
            ->orWhere('location', 'like', '%Karang Rejo%')
            ->first();

if ($sppg) {
    $sppg->latitude = 3.010000;
    $sppg->longitude = 99.111889;
    $sppg->radius = 150;
    $sppg->save();

    echo "SUCCESS: SPPG {$sppg->name} updated.\n";
    echo "New Latitude: {$sppg->latitude}\n";
    echo "New Longitude: {$sppg->longitude}\n";
    echo "New Radius: {$sppg->radius}m\n";
} else {
    echo "ERROR: SPPG Karang Rejo not found in database.\n";
    
    // List available SPPGs for debugging
    echo "Available SPPGs:\n";
    foreach (Sppg::all() as $s) {
        echo "- ID: {$s->id}, Name: {$s->name}\n";
    }
}
