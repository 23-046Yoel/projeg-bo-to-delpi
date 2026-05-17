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
echo "🍲 DAFTAR DISHES LIVE - aladelphi.or.id\n";
echo "==========================================\n\n";

$dishes = $pdo->query("SELECT id, name FROM dishes ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
foreach ($dishes as $dish) {
    echo "ID: " . str_pad($dish['id'], 3) . " | Name: {$dish['name']}\n";
}

echo "\n--- PORTIONS ESTIMATES FOR ACTIVE SPPGS ---\n";
$sppgs = $pdo->query("SELECT id, name FROM sppgs ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
foreach ($sppgs as $s) {
    $bgStmt = $pdo->prepare("SELECT SUM(porsi_kecil) as kecil, SUM(porsi_besar) as besar FROM beneficiary_groups WHERE sppg_id = ?");
    $bgStmt->execute([$s['id']]);
    $res = $bgStmt->fetch(PDO::FETCH_ASSOC);
    echo "SPPG ID: {$s['id']} ({$s['name']}) -> Kecil: " . ($res['kecil'] ?: 0) . " | Besar: " . ($res['besar'] ?: 0) . "\n";
}

echo '</pre>';
