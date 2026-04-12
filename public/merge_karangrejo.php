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
echo "🚀 MERGE SPPG KARANG REJO (ID 2 -> ID 3)\n";
echo "========================================\n\n";

try {
    $pdo->beginTransaction();

    $tables = [
        'beneficiary_groups',
        'menus',
        'users',
        'volunteer_attendances',
        'material_requests',
        'suppliers',
        'distribution_routes',
        'materials',
        'beneficiaries',
        'orders',
        'material_logs',
        'mbg_distributions',
        'news',
        'payments'
    ];

    foreach ($tables as $table) {
        $stmt = $pdo->prepare("UPDATE $table SET sppg_id = 3 WHERE sppg_id = 2");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
            echo "✅ Tabel $table: $count data dipindahkan ke ID 3.\n";
        }
    }

    // Update Nama di ID 3 (Gunakan nama resmi SPPG Karang Rejo)
    $pdo->exec("UPDATE sppgs SET name = 'SPPG Karang Rejo' WHERE id = 3");
    echo "✅ Nama SPPG ID 3 diubah menjadi 'SPPG Karang Rejo'.\n";

    // Hapus ID 2
    $pdo->exec("DELETE FROM sppgs WHERE id = 2");
    echo "✅ SPPG ID 2 (Duplikat) telah DIHAPUS.\n";

    $pdo->commit();
    echo "\n<span style='color:#3fb950; font-weight:bold; font-size:16px;'>🎉 PENGGABUNGAN SELESAI!</span>\n";
    echo "Sekarang Karang Rejo hanya ada satu (ID 3).\n";

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo "\n<span style='color:#f85149'>❌ ERROR: " . $e->getMessage() . "</span>\n";
}

echo '</pre>';
