<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\BeneficiaryGroup;

// Show all users and their sppg_id
echo "=== DAFTAR USER ===\n";
User::all()->each(function($u) {
    echo "ID: {$u->id} | Name: {$u->name} | sppg_id: " . ($u->sppg_id ?? 'NULL') . " | role: {$u->role}\n";
});

echo "\n=== DAFTAR BENEFICIARY GROUPS ===\n";
BeneficiaryGroup::all()->each(function($g) {
    echo "ID: {$g->id} | Name: {$g->name} | sppg_id: " . ($g->sppg_id ?? 'NULL') . "\n";
});
