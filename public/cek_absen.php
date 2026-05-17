<?php
header('Content-Type: text/plain');
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\VolunteerAttendance;
use App\Models\User;

echo "--- ALL YOEL USERS ---\n";
$users = User::where('name', 'like', '%Yoel%')->get();
foreach ($users as $u) {
    echo "ID: " . $u->id . " | Name: " . $u->name . " | Phone: " . $u->phone . " | Email: " . $u->email . " | SPPG ID: " . $u->sppg_id . "\n";
}

echo "\n--- ALL ATTENDANCES CREATED TODAY (" . date('Y-m-d') . ") ---\n";
$todayAttendances = VolunteerAttendance::with('user', 'sppg')
    ->whereDate('created_at', date('Y-m-d'))
    ->latest()
    ->get();

if ($todayAttendances->isEmpty()) {
    echo "No attendances recorded today.\n";
} else {
    foreach ($todayAttendances as $att) {
        echo "ID: " . $att->id . " | User: " . ($att->user->name ?? 'Unknown') . " | Status: " . $att->status . " | Created At: " . $att->created_at . " | Coordinates: " . $att->latitude . ", " . $att->longitude . " | Address: " . $att->address . "\n";
    }
}

echo "\n--- LATEST 10 GENERAL ATTENDANCES ---\n";
$latest = VolunteerAttendance::with('user', 'sppg')->latest()->take(10)->get();
foreach ($latest as $att) {
    echo "ID: " . $att->id . " | User: " . ($att->user->name ?? 'Unknown') . " | Status: " . $att->status . " | Created At: " . $att->created_at . " | Coordinates: " . $att->latitude . ", " . $att->longitude . "\n";
}
