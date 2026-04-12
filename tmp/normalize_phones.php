<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::all();
$count = 0;

foreach ($users as $u) {
    if (!$u->phone) continue;

    $oldPhone = $u->phone;
    $newPhone = preg_replace('/[^0-9]/', '', $oldPhone);
    
    if (str_starts_with($newPhone, '0')) {
        $newPhone = '62' . substr($newPhone, 1);
    } elseif (str_starts_with($newPhone, '8')) {
        $newPhone = '62' . $newPhone;
    }
    
    if ($oldPhone !== $newPhone) {
        $exists = User::where('phone', $newPhone)->where('id', '!=', $u->id)->first();
        if ($exists) {
            echo "SKIPPING: $newPhone already exists for user ID " . $exists->id . " while processing User ID " . $u->id . "\n";
            continue;
        }
        $u->phone = $newPhone;
        $u->save();
        $count++;
        echo "Updated: $oldPhone -> $newPhone\n";
    }
}

echo "Total updated: $count\n";
