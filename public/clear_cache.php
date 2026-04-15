<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Console\Kernel;

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "<h1>Clearing Application Cache - Bo To Delphi</h1>";

try {
    Artisan::call('cache:clear');
    echo "<li>Cache cleared!</li>";
} catch (\Exception $e) { echo "<li>Cache clear failed: " . $e->getMessage() . "</li>"; }

try {
    Artisan::call('config:clear');
    echo "<li>Config cleared!</li>";
} catch (\Exception $e) { echo "<li>Config clear failed: " . $e->getMessage() . "</li>"; }

try {
    Artisan::call('route:clear');
    echo "<li>Route cleared!</li>";
} catch (\Exception $e) { echo "<li>Route clear failed: " . $e->getMessage() . "</li>"; }

try {
    Artisan::call('view:clear');
    echo "<li>View cleared!</li>";
} catch (\Exception $e) { echo "<li>View clear failed: " . $e->getMessage() . "</li>"; }

echo "<h2>SEMUA CACHE BERHASIL DIBERSIHKAN!</h2>";
echo "<p>Silakan coba kembali bot WhatsApp-nya.</p>";
