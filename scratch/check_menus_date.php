<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;

echo "=== CHECKING MENUS FOR 2026-05-17 ===\n";
$menus = Menu::where('date', '2026-05-17')->get();
if ($menus->isEmpty()) {
    echo "No menus found for 2026-05-17.\n";
} else {
    foreach ($menus as $m) {
        echo "ID: {$m->id} | SPPG: {$m->sppg_id} | Date: {$m->date}\n";
        echo "  Karbo: {$m->karbo}\n";
        echo "  Hewani: {$m->protein_hewani}\n";
        echo "  Nabati: {$m->protein_nabati}\n";
        echo "  Sayur: {$m->sayur}\n";
        echo "  Buah: {$m->buah}\n";
        echo "  Pelengkap: {$m->pelengkap}\n";
        echo "  Content: {$m->content}\n\n";
    }
}

echo "=== ALL RECENTS MENUS ===\n";
$recent = Menu::orderBy('date', 'desc')->limit(10)->get();
foreach ($recent as $m) {
    echo "Date: {$m->date} | SPPG: {$m->sppg_id} | Karbo: {$m->karbo}\n";
}
