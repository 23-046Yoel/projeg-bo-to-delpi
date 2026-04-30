<?php
/**
 * SCRIPT UNTUK MENGHIDUPKAN WEBSITE KEMBALI
 * Akses: aladelphi.or.id/website_hidup.php
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Console\Kernel;

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "<body style='font-family:sans-serif; background:#f4f4f4; padding:50px; text-align:center;'>";
echo "<div style='background:white; padding:30px; border-radius:10px; box-shadow:0 4px 6px rgba(0,0,0,0.1); display:inline-block;'>";
echo "<h1 style='color:#27ae60;'>🚀 Menghidupkan Website...</h1>";

try {
    // Perintah untuk menormalkan kembali website
    Artisan::call('up');
    
    echo "<h2 style='color:#27ae60;'>✅ BERHASIL!</h2>";
    echo "<p>Website sekarang sudah <b>ONLINE</b> dan bisa diakses semua orang.</p>";
} catch (\Exception $e) {
    echo "<h2 style='color:#c0392b;'>❌ GAGAL!</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

echo "<br><a href='index.php' style='color:#3498db; text-decoration:none;'>← Kembali ke Home</a>";
echo "</div></body>";
