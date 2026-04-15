<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Console\Kernel;

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "<h1>Bo To Delphi - Server Manager</h1>";

echo "<h2>1. Mencoba Update Kode (Git Pull)...</h2>";
echo "<pre>";
$pullOutput = shell_exec("git pull origin main 2>&1");
echo $pullOutput ?: "Gagal menjalankan shell_exec. Pastikan fungsi ini aktif di server.";
echo "</pre>";

echo "<h2>2. Membersihkan Cache...</h2>";
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

echo "<h2>SELESAI!</h2>";
echo "<p>Kalau di bagian Git Pull ada tulisan 'Already up to date' atau 'Fast-forward', berarti server sudah versi terbaru!</p>";
