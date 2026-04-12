<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Sppg;

$karangRejo = Sppg::where('name', 'like', '%Karang Rejo%')->get();
echo "Found: " . $karangRejo->count() . " entries\n";

if ($karangRejo->count() > 1) {
    $main = $karangRejo->shift();
    echo "Main SPPG: ID {$main->id} - {$main->name}\n";
    
    foreach ($karangRejo as $duplicate) {
        echo "Updating references for duplicate ID {$duplicate->id}...\n";
        
        // Update all related tables
        \DB::table('users')->where('sppg_id', $duplicate->id)->update(['sppg_id' => $main->id]);
        \DB::table('beneficiaries')->where('sppg_id', $duplicate->id)->update(['sppg_id' => $main->id]);
        \DB::table('beneficiary_groups')->where('sppg_id', $duplicate->id)->update(['sppg_id' => $main->id]);
        \DB::table('menus')->where('sppg_id', $duplicate->id)->update(['sppg_id' => $main->id]);
        \DB::table('materials')->where('sppg_id', $duplicate->id)->update(['sppg_id' => $main->id]);
        \DB::table('payments')->where('sppg_id', $duplicate->id)->update(['sppg_id' => $main->id]);
        \DB::table('distribution_routes')->where('sppg_id', $duplicate->id)->update(['sppg_id' => $main->id]);
        \DB::table('material_logs')->where('sppg_id', $duplicate->id)->update(['sppg_id' => $main->id]);
        
        echo "Deleting duplicate ID {$duplicate->id}\n";
        $duplicate->delete();
    }
} else {
    echo "No duplicates found.\n";
}
