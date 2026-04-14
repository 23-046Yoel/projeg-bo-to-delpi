<?php
/**
 * ONE-TIME SCRIPT TO DELETE DUPLICATE STAFF FROM DOLOG BATU NANGGAR
 */
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\Sppg;
use App\Models\User;

$key = $_GET['key'] ?? '';
if ($key !== 'hapus24') {
    die('Unauthorized.');
}

echo "<pre style='background:#fef2f2;color:#991b1b;padding:20px;border-radius:12px;font-family:monospace;border:2px solid #ef4444;'>";
echo "🛠️ <b>DUPICATE STAFF CLEANUP TOOL</b>\n\n";

$targetName = "Dolog Batu Nanggar";
$target = Sppg::where('name', 'LIKE', "%$targetName%")->first();

if (!$target) {
    // Try other variation
    $target = Sppg::where('name', 'LIKE', "%Batu Nanggar%")->first();
}

if ($target) {
    echo "📍 Found SPPG: <b>" . $target->name . "</b> (ID: " . $target->id . ")\n";
    
    $users = User::where('sppg_id', $target->id)->get();
    $count = $users->count();
    
    if ($count > 0) {
        echo "👥 Found <b>$count</b> users to delete.\n";
        foreach ($users as $user) {
            echo "   ❌ Deleting: " . $user->name . " (" . $user->phone . ")\n";
            $user->delete();
        }
        echo "\n✅ <b>CLEANUP COMPLETE!</b>\n";
    } else {
        echo "⚠️ No users found for this SPPG. Maybe already deleted?\n";
    }
} else {
    echo "❌ <b>ERROR</b>: SPPG with name 'Dolog Batu Nanggar' not found in database.\n";
    echo "\nAvailable SPPGs:\n";
    foreach(Sppg::all() as $s) {
        echo "- ID: {$s->id} | {$s->name}\n";
    }
}

echo "</pre>";
