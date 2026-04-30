<?php
/**
 * SCRIPT UNTUK MEMAKSA UPDATE DARI GITHUB (VERSI AUTO-PHP)
 */

echo "<body style='background:#0f172a; color:#4ade80; font-family:monospace; padding:20px;'>";
echo "<h2>🚀 Memulai Force Update (Auto-PHP Detection)...</h2>";
echo "<hr style='border:1px solid #1e293b;'>";

// 1. Cari PHP yang versinya 8.1 ke atas (Khusus CyberPanel/Litespeed)
$phpPath = 'php'; // default
$candidates = [
    '/usr/local/lsws/lsphp82/bin/php',
    '/usr/local/lsws/lsphp81/bin/php',
    '/usr/local/lsws/lsphp80/bin/php',
];
foreach ($candidates as $bin) {
    if (file_exists($bin)) {
        $phpPath = $bin;
        break;
    }
}
echo "<strong>Info:</strong> Menggunakan PHP: <code>$phpPath</code><br><br>";

echo "<h3>1. Mengecek Status Git:</h3><pre style='background:#1e293b; padding:15px; border-radius:8px;'>";
passthru("git status 2>&1");
echo "</pre>";

echo "<h3>2. Fetch & Reset Hard:</h3><pre style='background:#1e293b; padding:15px; border-radius:8px;'>";
passthru("git fetch --all 2>&1");
passthru("git reset --hard origin/main 2>&1");
echo "</pre>";

echo "<h3>3. Membersihkan Cache Laravel:</h3><pre style='background:#1e293b; padding:15px; border-radius:8px;'>";
// Menggunakan $phpPath yang ditemukan
passthru("$phpPath ../artisan optimize:clear 2>&1");
echo "</pre>";

echo "<hr style='border:1px solid #1e293b;'>";
echo "<h2 style='color:white;'>✅ SELESAI!</h2>";
echo "<p>Sekarang silakan cek Control Panel baru Anda di: <a href='/clear_cache.php' style='color:#6366f1;'>aladelphi.or.id/clear_cache.php</a></p>";
echo "</body>";
