<?php
/**
 * SCRIPT UNTUK MEMATIKAN WEBSITE (MAINTENANCE MODE)
 * Akses: aladelphi.or.id/website_mati.php
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Console\Kernel;

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "<body style='font-family:sans-serif; background:#f4f4f4; padding:50px; text-align:center;'>";
echo "<div style='background:white; padding:30px; border-radius:10px; box-shadow:0 4px 6px rgba(0,0,0,0.1); display:inline-block;'>";
echo "<h1 style='color:#e74c3c;'>🛑 Mematikan Website...</h1>";

try {
    // Mode 'down' dengan secret key agar Admin tetap bisa masuk
    // Anda bisa akses website saat mati lewat: aladelphi.or.id/?secret=aladelphi-admin
    Artisan::call('down', [
        '--secret' => 'aladelphi-admin',
        '--refresh' => 15, // Refresh browser pengunjung setiap 15 detik
    ]);
    
    echo "<h2 style='color:#27ae60;'>✅ BERHASIL!</h2>";
    echo "<p>Website sekarang dalam <b>Mode Maintenance</b>.</p>";
    echo "<p>Pengunjung umum akan melihat pesan 'Service Unavailable'.</p>";
    echo "<hr>";
    echo "<p style='font-size:14px;'>PENTING: Anda tetap bisa melihat website dengan link rahasia ini:<br>";
    echo "<a href='https://aladelphi.or.id/?secret=aladelphi-admin' target='_blank'>Klik Disini untuk Akses Admin</a></p>";
} catch (\Exception $e) {
    echo "<h2 style='color:#c0392b;'>❌ GAGAL!</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

echo "<br><a href='index.php' style='color:#3498db; text-decoration:none;'>← Kembali ke Depan</a>";
echo "</div></body>";
