<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::orderBy('id')->get(['id', 'name', 'phone', 'role']);
echo "Total Users: " . $users->count() . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo sprintf("%-5s | %-30s | %-20s | %-10s", "ID", "Nama", "No HP", "Role") . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
foreach ($users as $u) {
    echo sprintf("%-5s | %-30s | %-20s | %-10s", $u->id, $u->name, $u->phone, $u->role) . PHP_EOL;
}
echo str_repeat("-", 70) . PHP_EOL;
