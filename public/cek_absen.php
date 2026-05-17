<?php
header('Content-Type: text/plain');
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\VolunteerAttendance;
use App\Models\User;

$user = User::where('name', 'like', '%Yoel%')->first();
if ($user) {
    echo "User Yoel: ID = " . $user->id . ", Phone = " . $user->phone . "\n";
    $attendances = VolunteerAttendance::where('user_id', $user->id)->latest()->take(10)->get();
    foreach ($attendances as $att) {
        echo "Attendance ID: " . $att->id . " | Status: " . $att->status . " | Created At: " . $att->created_at . " | SPPG: " . $att->sppg_id . " | Address: " . $att->address . "\n";
    }
} else {
    echo "User not found\n";
}

echo "\n--- LAST 50 LINES OF LARAVEL LOG ---\n";
$logPath = storage_path('logs/laravel.log');
if (file_exists($logPath)) {
    $lines = file($logPath);
    $lastLines = array_slice($lines, -50);
    echo implode("", $lastLines);
} else {
    echo "Log file not found at: $logPath\n";
}
