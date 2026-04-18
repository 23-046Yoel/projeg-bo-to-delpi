<?php
// ⚠️ HAPUS FILE INI SETELAH DIGUNAKAN!
// Akses file ini sekali via browser untuk mengaktifkan maintenance mode

$secret = $_GET['key'] ?? '';

// Kunci rahasia agar tidak sembarang orang bisa akses
if ($secret !== 'butuhupgrademodel') {
    http_response_code(403);
    die('❌ Akses ditolak.');
}

chdir(dirname(__DIR__));

$action = $_GET['action'] ?? 'down';

if ($action === 'up') {
    $output = shell_exec('php artisan up 2>&1');
    echo "✅ <strong>Maintenance Mode DIMATIKAN!</strong><br>";
} else {
    $output = shell_exec('php artisan down 2>&1');
    echo "🔴 <strong>Maintenance Mode DIAKTIFKAN!</strong><br>";
}

echo "<pre>" . htmlspecialchars($output) . "</pre>";
echo "<hr>";
echo "<small>⚠️ Segera hapus file ini dari server setelah selesai!</small>";
