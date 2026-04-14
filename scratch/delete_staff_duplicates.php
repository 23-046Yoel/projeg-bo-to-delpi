<?php
// Script to list all SPPGs and delete users for a specific one
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\Sppg;
use App\Models\User;

echo "--- LISTING ALL SPPGs ---\n";
$sppgs = Sppg::all();
foreach($sppgs as $sppg) {
    $userCount = User::where('sppg_id', $sppg->id)->count();
    echo "ID: {$sppg->id} | Name: {$sppg->name} | Users: {$userCount}\n";
}

$targetName = "Dolog Batu Nanggar";
$target = Sppg::where('name', 'LIKE', "%$targetName%")->first();

if ($target) {
    echo "\n--- FOUND TARGET: {$target->name} (ID: {$target->id}) ---\n";
    $usersToDelete = User::where('sppg_id', $target->id)->get();
    echo "Count to delete: " . $usersToDelete->count() . "\n";
    
    foreach($usersToDelete as $user) {
        echo "Deleting User: {$user->name} (Phone: {$user->phone})\n";
        // To actually delete, uncomment line below
        $user->delete();
    }
    echo "Deletion completed.\n";
} else {
    echo "\nTarget SPPG '$targetName' not found.\n";
}
