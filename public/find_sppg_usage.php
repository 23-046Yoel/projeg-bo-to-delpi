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
echo "🔍 MENCARI TABEL DENGAN sppg_id\n";
echo "==================================\n\n";

$tables = $pdo->query("SELECT DISTINCT TABLE_NAME 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE COLUMN_NAME = 'sppg_id' 
    AND TABLE_SCHEMA = '$d'")->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    $count = $pdo->query("SELECT COUNT(*) FROM $table WHERE sppg_id = 2")->fetchColumn();
    echo "Tabel: " . str_pad($table, 25) . " | Data di ID 2: $count\n";
}

echo "\n--- INFORMASI SPPG ---\n";
$sppg2 = $pdo->query("SELECT * FROM sppgs WHERE id = 2")->fetch(PDO::FETCH_ASSOC);
$sppg3 = $pdo->query("SELECT * FROM sppgs WHERE id = 3")->fetch(PDO::FETCH_ASSOC);

echo "ID 2: " . ($sppg2 ? $sppg2['name'] : "TIDAK ADA") . "\n";
echo "ID 3: " . ($sppg3 ? $sppg3['name'] : "TIDAK ADA") . "\n";

echo '</pre>';
