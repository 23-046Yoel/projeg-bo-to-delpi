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
echo "📊 CEK USER DATABASE - alad_boto_delphi\n";
echo "==========================================\n\n";

// Total per role
$roles = $pdo->query("SELECT role, COUNT(*) as total FROM users GROUP BY role ORDER BY total DESC")->fetchAll(PDO::FETCH_ASSOC);
$grandTotal = 0;
echo "JUMLAH USER PER ROLE:\n";
foreach ($roles as $r) {
    printf("  %-25s : %d orang\n", ($r['role'] ?: 'no role'), $r['total']);
    $grandTotal += $r['total'];
}
echo "  ─────────────────────────────────\n";
echo "  TOTAL SEMUA USER          : $grandTotal orang\n\n";

// Semua nomor HP
echo "DAFTAR NOMOR HP TERDAFTAR:\n";
echo str_repeat('─', 70) . "\n";
printf("  %-4s %-25s %-18s %-12s\n", 'ID', 'Nama', 'Phone', 'Role');
echo str_repeat('─', 70) . "\n";
$users = $pdo->query("SELECT id, name, phone, role FROM users ORDER BY role, id")->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $u) {
    printf("  %-4s %-25s %-18s %-12s\n",
        $u['id'],
        substr($u['name'] ?? '-', 0, 24),
        $u['phone'] ?? '(kosong)',
        $u['role'] ?? '-'
    );
}
echo '</pre>';
