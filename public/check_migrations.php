<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Migration Status:\n";
    \Illuminate\Support\Facades\Artisan::call('migrate:status');
    echo \Illuminate\Support\Facades\Artisan::output();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
