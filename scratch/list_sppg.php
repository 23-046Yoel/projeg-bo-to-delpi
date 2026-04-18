<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Sppg;

echo "--- LIST ALL SPPG ---\n";
foreach (Sppg::all() as $s) {
    echo "ID: {$s->id} | Name: {$s->name} | Lat: {$s->latitude} | Lng: {$s->longitude} | Radius: {$s->radius}m\n";
}
