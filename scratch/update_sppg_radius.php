<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Sppg;

echo "--- UPDATING RADIUS ---\n";

foreach (Sppg::all() as $s) {
    if ($s->radius < 150) {
        $s->radius = 150;
        $s->save();
        echo "ID {$s->id} ({$s->name}) radius updated to 150m.\n";
    }
}
