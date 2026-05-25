<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain');

try {
    $affected = DB::table('beneficiary_groups')
        ->where('type', 'sekolah')
        ->where('count_siswa', 0)
        ->where('count_guru', 0)
        ->update([
            'count_siswa' => DB::raw('porsi_besar'),
            'count_guru' => DB::raw('porsi_kecil')
        ]);

    echo "SUCCESS: Successfully updated {$affected} school beneficiary groups where count was 0!\n";
    
    // Clear Laravel caches to ensure the view reads the fresh data
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    echo "SUCCESS: Application cache cleared successfully.";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
