<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$counts = DB::table('menus')
    ->select('sppg_id', DB::raw('count(*) as total'))
    ->groupBy('sppg_id')
    ->get();

echo "=== MENUS PER SPPG ===\n";
foreach ($counts as $c) {
    $sppgName = DB::table('sppgs')->where('id', $c->sppg_id)->value('name') ?? 'NULL / All';
    echo "SPPG ID: " . ($c->sppg_id ?? 'NULL') . " ({$sppgName}) | Total Menus: {$c->total}\n";
}

$dishMenuCount = DB::table('dish_menu')->count();
echo "\nTotal dish_menu pivot rows: {$dishMenuCount}\n";

if ($dishMenuCount > 0) {
    echo "Sample dish_menu rows:\n";
    $samples = DB::table('dish_menu')->limit(10)->get();
    foreach ($samples as $s) {
        echo "  Menu ID: {$s->menu_id} | Dish ID: {$s->dish_id} | Portions: {$s->portions} | Kecil: {$s->porsi_kecil} | Besar: {$s->porsi_besar}\n";
    }
}
