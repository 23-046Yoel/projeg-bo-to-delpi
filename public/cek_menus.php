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
echo "📅 CEK MENUS DATABASE - aladelphi.or.id\n";
echo "==========================================\n\n";

// Count total menus
$total = $pdo->query("SELECT COUNT(*) FROM menus")->fetchColumn();
echo "Total Menus: $total\n\n";

// Group by SPPG
$sppgs = $pdo->query("SELECT sppg_id, COUNT(*) as total FROM menus GROUP BY sppg_id")->fetchAll(PDO::FETCH_ASSOC);
echo "Jumlah Menu per SPPG:\n";
foreach ($sppgs as $s) {
    $sppgName = 'Unknown';
    if ($s['sppg_id']) {
        $stmt = $pdo->prepare("SELECT name FROM sppgs WHERE id = ?");
        $stmt->execute([$s['sppg_id']]);
        $sppgName = $stmt->fetchColumn() ?: 'Unknown';
    } else {
        $sppgName = 'NULL / Global';
    }
    echo "  SPPG ID: " . ($s['sppg_id'] ?? 'NULL') . " ({$sppgName}) : {$s['total']} menus\n";
}
echo "\n";

// List recent 15 menus
echo "15 MENU TERBARU:\n";
echo str_repeat('─', 80) . "\n";
printf("  %-10s | %-7s | %-12s | %-12s | %-12s | %-12s\n", 'Date', 'SPPG ID', 'Karbo', 'Hewani', 'Nabati', 'Sayur');
echo str_repeat('─', 80) . "\n";

$menus = $pdo->query("SELECT id, date, sppg_id, karbo, protein_hewani, protein_nabati, sayur, buah, pelengkap, content FROM menus ORDER BY date DESC, id DESC LIMIT 15")->fetchAll(PDO::FETCH_ASSOC);
foreach ($menus as $m) {
    printf("  %-10s | %-7s | %-12s | %-12s | %-12s | %-12s\n",
        $m['date'],
        $m['sppg_id'] ?? 'NULL',
        substr($m['karbo'] ?? '-', 0, 12),
        substr($m['protein_hewani'] ?? '-', 0, 12),
        substr($m['protein_nabati'] ?? '-', 0, 12),
        substr($m['sayur'] ?? '-', 0, 12)
    );
    if ($m['content']) {
        echo "    Content JSON/String: {$m['content']}\n";
    }
    
    // Check pivot dish_menu on server
    $dishStmt = $pdo->prepare("SELECT dm.*, d.name as dish_name FROM dish_menu dm JOIN dishes d ON dm.dish_id = d.id WHERE dm.menu_id = ?");
    $dishStmt->execute([$m['id']]);
    $dishes = $dishStmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($dishes)) {
        echo "    Dishes:\n";
        foreach ($dishes as $d) {
            echo "      - {$d['dish_name']} (ID: {$d['dish_id']}) | Portions: {$d['portions']} (Kecil: {$d['porsi_kecil']}, Besar: {$d['porsi_besar']})\n";
        }
    }
    echo "\n";
}
echo '</pre>';
