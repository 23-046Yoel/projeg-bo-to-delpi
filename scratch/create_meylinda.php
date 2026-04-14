<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

use App\Models\User;
use App\Models\Sppg;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$name = 'Meylinda';
$phone = '6288260013607';
$sppgId = 4; // SPPG Balimbingan II

echo "Creating/Updating user for $name ($phone)...\n";

try {
    $user = User::updateOrCreate(
        ['phone' => $phone],
        [
            'name' => $name,
            'email' => Str::slug($name) . '@delphi.or.id',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_PENGAWAS_GIZI,
            'sppg_id' => $sppgId,
        ]
    );

    echo "User created successfully!\n";
    echo "Name: " . $user->name . "\n";
    echo "Role: " . $user->role . "\n";
    echo "SPPG ID: " . $user->sppg_id . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
