<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: text/plain');

echo "=== USERS ===\n";
foreach(App\Models\User::all() as $u) {
    echo "ID: {$u->id} | Name: {$u->name} | Role: {$u->role} | SPPG ID: {$u->sppg_id} (Name: " . ($u->sppg->name ?? 'None') . ") | Phone: {$u->phone}\n";
}
