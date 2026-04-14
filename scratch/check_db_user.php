<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use App\Models\Sppg;
use App\Models\User;
use App\Models\Beneficiary;
use App\Models\Supplier;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$searchTerm = 'Meylinda';
$phoneTerm = '88260013607';

echo "Searching for Name: $searchTerm\n";
echo "Searching for Phone: $phoneTerm\n\n";

try {
    DB::connection()->getPdo();
    echo "Connected successfully to " . config('database.connections.mysql.database') . "\n\n";
} catch (\Exception $e) {
    echo "Initial connection failed: " . $e->getMessage() . "\n";
    echo "Attempting with empty password...\n";
    config(['database.connections.mysql.password' => '']);
    try {
        DB::purge('mysql');
        DB::connection()->getPdo();
        echo "Connected successfully with empty password!\n\n";
    } catch (\Exception $e) {
        die("Could not connect to database: " . $e->getMessage());
    }
}

$results = [];

// Search SPPGs
$results['sppgs'] = Sppg::where('name', 'like', "%$searchTerm%")
    ->orWhere('phone', 'like', "%$phoneTerm%")
    ->get();

// Search Users
$results['users'] = User::where('name', 'like', "%$searchTerm%")
    ->orWhere('phone', 'like', "%$phoneTerm%")
    ->orWhere('whatsapp', 'like', "%$phoneTerm%")
    ->get();

// Search Beneficiaries
$results['beneficiaries'] = Beneficiary::where('name', 'like', "%$searchTerm%")
    ->orWhere('phone', 'like', "%$phoneTerm%")
    ->get();

// Search Suppliers
$results['suppliers'] = Supplier::where('name', 'like', "%$searchTerm%")
    ->orWhere('phone', 'like', "%$phoneTerm%")
    ->get();

foreach ($results as $table => $rows) {
    echo "--- Results in $table ---\n";
    if ($rows->isEmpty()) {
        echo "None found.\n";
    } else {
        foreach ($rows as $row) {
            echo "ID: " . $row->id . " | Name: " . $row->name . " | Phone: " . ($row->phone ?? $row->whatsapp ?? 'N/A') . "\n";
        }
    }
    echo "\n";
}
