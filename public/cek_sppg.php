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
echo "🏢 DATA SPPG (Unit Dapur)\n";
echo "============================\n\n";

$sppgs = $pdo->query("SELECT id, name FROM sppgs ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

foreach ($sppgs as $sppg) {
    $userCount = $pdo->prepare("SELECT COUNT(*) FROM users WHERE sppg_id = ?");
    $userCount->execute([$sppg['id']]);
    $count = $userCount->fetchColumn();
    
    echo "ID: " . str_pad($sppg['id'], 3) . " | Name: " . str_pad($sppg['name'], 30) . " | Users: $count\n";
}

echo "\n--- USER TANPA SPPG ---\n";
$noSppg = $pdo->query("SELECT COUNT(*) FROM users WHERE sppg_id IS NULL")->fetchColumn();
echo "Total User Tanpa SPPG: $noSppg\n";

echo '</pre>';
