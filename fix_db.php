<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;
use App\Models\Dish;

echo "Starting database fix...\n";

$menus = Menu::all();
$fixedCount = 0;

foreach ($menus as $menu) {
    if ($menu->dishes()->count() == 0) {
        $items = [
            'karbo' => $menu->karbo,
            'protein_hewani' => $menu->protein_hewani,
            'protein_nabati' => $menu->protein_nabati,
            'sayur' => $menu->sayur,
            'buah' => $menu->buah,
            'pelengkap' => $menu->pelengkap
        ];
        
        $hasData = false;         
        foreach ($items as $type => $name) {
            if ($name && $name != '-' && trim($name) != '') {
                $dish = Dish::firstOrCreate(['name' => trim($name)]);
                $menu->dishes()->syncWithoutDetaching([$dish->id => ['portions' => 1]]);
                $hasData = true;
            }
        }
        
        if ($hasData) {
            $fixedCount++;
            echo "Fixed menu for date: " . $menu->date . "\n";
        }
    }
}

echo "SUCCESS: $fixedCount menus have been linked to dishes!\n";
    