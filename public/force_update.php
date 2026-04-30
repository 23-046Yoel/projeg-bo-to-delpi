<?php
/**
 * SCRIPT UNTUK MEMAKSA UPDATE DARI GITHUB
 * Jalankan ini di server jika CyberPanel tidak mau Pull.
 */

echo "<body style='background:#0f172a; color:#4ade80; font-family:monospace; padding:20px;'>";
echo "<h2>🚀 Memulai Force Update...</h2>";
echo "<hr style='border:1px solid #1e293b;'>";

echo "<h3>1. Mengecek Status Git:</h3><pre style='background:#1e293b; padding:15px; border-radius:8px;'>";
passthru("git status 2>&1");
echo "</pre>";

echo "<h3>2. Fetch & Reset Hard (Menarik Paksa dari GitHub):</h3><pre style='background:#1e293b; padding:15px; border-radius:8px;'>";
passthru("git fetch --all 2>&1");
passthru("git reset --hard origin/main 2>&1");
echo "</pre>";

echo "<h3>3. Membersihkan Cache Laravel:</h3><pre style='background:#1e293b; padding:15px; border-radius:8px;'>";
// Karena script ini di folder public, kita harus naik satu folder untuk artisan
passthru("php ../artisan optimize:clear 2>&1");
echo "</pre>";

echo "<hr style='border:1px solid #1e293b;'>";
echo "<h2 style='color:white;'>✅ SELESAI!</h2>";
echo "<p>Sekarang silakan cek Control Panel baru Anda di: <a href='/clear_cache.php' style='color:#6366f1;'>aladelphi.or.id/clear_cache.php</a></p>";
echo "</body>";
