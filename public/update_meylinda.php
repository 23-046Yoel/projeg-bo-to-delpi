<?php
$secret = $_GET['key'] ?? '';
if ($secret !== 'fixboto2024') die('403 Forbidden');

$laravelRoot = '/home/aladelphi.or.id/public_html';
$env = file_get_contents($laravelRoot . '/.env');
preg_match('/DB_HOST=(.+)/',     $env, $m); $h = trim($m[1]);
preg_match('/DB_DATABASE=(.+)/', $env, $m); $d = trim($m[1]);
preg_match('/DB_USERNAME=(.+)/', $env, $m); $u = trim($m[1]);
preg_match('/DB_PASSWORD=(.*)/', $env, $m); $p = trim($m[1]);

$pdo = new PDO("mysql:host=$h;dbname=$d;charset=utf8mb4", $u, $p);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo '<pre style="background:#0d1117;color:#e6edf3;padding:20px;font-size:13px;font-family:monospace;">';
echo "✏️  Update User - Meylinda\n";
echo "============================\n\n";

// Cari SPPG Tanah Jawa
$sppg = $pdo->query("SELECT id, name FROM sppgs WHERE name LIKE '%Tanah Jawa%' OR name LIKE '%tanah jawa%' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$sppgId = $sppg ? $sppg['id'] : null;
echo "SPPG Tanah Jawa: " . ($sppg ? $sppg['name'] . " (ID: $sppgId)" : "TIDAK DITEMUKAN") . "\n\n";

// Update user
$now = date('Y-m-d H:i:s');
$stmt = $pdo->prepare("UPDATE users SET name=?, sppg_id=?, updated_at=? WHERE phone=?");
$stmt->execute(['Meylinda', $sppgId, $now, '6288260013607']);

$affected = $stmt->rowCount();
if ($affected > 0) {
    echo "<span style='color:#3fb950'>✅ Berhasil update!</span>\n\n";
    
    // Tampilkan data setelah update
    $user = $pdo->query("SELECT id, name, phone, role, sppg_id FROM users WHERE phone='6288260013607'")->fetch(PDO::FETCH_ASSOC);
    echo "ID     : " . $user['id'] . "\n";
    echo "Nama   : " . $user['name'] . "\n";
    echo "Phone  : " . $user['phone'] . "\n";
    echo "Role   : " . $user['role'] . "\n";
    echo "SPPG ID: " . ($user['sppg_id'] ?? 'NULL') . "\n";
} else {
    echo "<span style='color:#f85149'>❌ User tidak ditemukan atau tidak ada perubahan.</span>\n";
}

echo "\n<span style='color:#f85149'>⚠️ HAPUS file ini setelah selesai!</span>\n";
echo '</pre>';
