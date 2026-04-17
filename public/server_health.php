<?php
/**
 * Server Health Check & System Maintenance Tool
 * ⚠️ HAPUS FILE INI SETELAH DIGUNAKAN!
 */

$secret_key = 'butuhupgrademodel'; // Kunci rahasia kamu
$key = $_GET['key'] ?? '';

if ($key !== $secret_key) {
    header('HTTP/1.1 403 Forbidden');
    die('Akses Ditolak.');
}

// Path ke file maintenance Laravel
$maintenance_file = __DIR__ . '/../storage/framework/down';
$action = $_GET['action'] ?? 'status';

if ($action === 'down') {
    // Membuat file 'down' untuk mengaktifkan maintenance mode
    $data = [
        'time' => time(),
        'status' => 503,
        'template' => null,
        'message' => 'Sistem sedang dalam pemeliharaan rutin. Silakan hubungi administrator untuk informasi lebih lanjut.',
        'retry' => null,
        'refresh' => null,
        'secret' => null,
        'allowed' => []
    ];
    
    if (file_put_contents($maintenance_file, json_encode($data))) {
        echo "<h2>🔴 SISTEM DINONAKTIFKAN (ERROR 503)</h2>";
        echo "<p>Website aladelphi.or.id sekarang tidak bisa diakses oleh publik.</p>";
    } else {
        echo "<h2>❌ GAGAL!</h2>";
        echo "<p>Folder storage tidak bisa ditulis. Pastikan permission folder storage adalah 775.</p>";
    }
} 
elseif ($action === 'up') {
    // Menghapus file 'down' untuk menormalkan kembali
    if (file_exists($maintenance_file)) {
        unlink($maintenance_file);
        echo "<h2>✅ SISTEM AKTIF KEMBALI</h2>";
        echo "<p>Website sudah normal kembali.</p>";
    } else {
        echo "<h2>ℹ️ Informasi</h2>";
        echo "<p>Sistem memang sudah dalam kondisi aktif.</p>";
    }
} 
else {
    $is_down = file_exists($maintenance_file);
    echo "<h2>Status Sistem: " . ($is_down ? "<span style='color:red'>OFF (Maintenance)</span>" : "<span style='color:green'>ON (Normal)</span>") . "</h2>";
    echo "<hr>";
    echo "<ul>";
    echo "<li><a href='?key=$secret_key&action=down'>Matikan Website (Error 503)</a></li>";
    echo "<li><a href='?key=$secret_key&action=up'>Nyalakan Website (Normal)</a></li>";
    echo "</ul>";
}

echo "<br><small>Hapus file ini (server_health.php) jika sudah tidak digunakan untuk keamanan.</small>";
