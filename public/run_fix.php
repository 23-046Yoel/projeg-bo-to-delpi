<?php
/**
 * ====================================================
 * SCRIPT DARURAT v2 - Bo To Delpi Server Fix
 * Jalankan via: https://aladelphi.or.id/run_fix.php
 * HAPUS FILE INI SETELAH SELESAI!
 * ====================================================
 */

$secret = $_GET['key'] ?? '';
if ($secret !== 'fixboto2024') {
    die('403 Forbidden - Tambahkan ?key=fixboto2024 di URL');
}

echo '<pre style="background:#0d1117;color:#e6edf3;padding:20px;font-size:13px;font-family:monospace;">';
echo "<span style='color:#58a6ff'>🚀 Bo To Delpi - Server Fix Script v2</span>\n";
echo "========================================\n";
echo "PHP Version (web): " . PHP_VERSION . "\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n\n";

$laravelRoot = '/home/aladelphi.or.id/public_html';

// ============================================
// Baca konfigurasi .env
// ============================================
$envContent = file_get_contents($laravelRoot . '/.env');
preg_match('/DB_HOST=(.+)/', $envContent, $m); $dbHost = trim($m[1] ?? '127.0.0.1');
preg_match('/DB_DATABASE=(.+)/', $envContent, $m); $dbName = trim($m[1] ?? '');
preg_match('/DB_USERNAME=(.+)/', $envContent, $m); $dbUser = trim($m[1] ?? '');
preg_match('/DB_PASSWORD=(.*)/', $envContent, $m); $dbPass = trim($m[1] ?? '');

echo "DB: $dbUser@$dbHost/$dbName\n\n";

// ============================================
// Koneksi PDO
// ============================================
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<span style='color:#3fb950'>✅ Koneksi database berhasil!</span>\n\n";
} catch (Exception $e) {
    echo "<span style='color:#f85149'>❌ Koneksi GAGAL: " . $e->getMessage() . "</span>\n";
    exit;
}

// ============================================
// Helper functions
// ============================================
function hasColumn($pdo, $table, $column) {
    $stmt = $pdo->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $stmt->rowCount() > 0;
}
function tableExists($pdo, $table) {
    $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
    return $stmt->rowCount() > 0;
}
function runSQL($pdo, $label, $sql) {
    try {
        $pdo->exec($sql);
        echo "<span style='color:#3fb950'>  ✅ $label</span>\n";
        return true;
    } catch (Exception $e) {
        echo "<span style='color:#f85149'>  ❌ $label: " . $e->getMessage() . "</span>\n";
        return false;
    }
}

// ============================================
// LANGKAH 1: Buat tabel community_prices
// ============================================
echo "--- <span style='color:#ffa657'>LANGKAH 1: Tabel community_prices</span> ---\n";
if (!tableExists($pdo, 'community_prices')) {
    runSQL($pdo, "Membuat tabel community_prices", "
        CREATE TABLE `community_prices` (
            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
            `item_name` varchar(255) NOT NULL,
            `price` decimal(12,2) NOT NULL,
            `unit` varchar(255) NOT NULL DEFAULT 'kg',
            `reporter_name` varchar(255) NOT NULL DEFAULT 'Anonim',
            `reporter_phone` varchar(255) DEFAULT NULL,
            `location` varchar(255) NOT NULL,
            `sumber_link` varchar(255) DEFAULT NULL,
            `likes` int NOT NULL DEFAULT '0',
            `is_verified` tinyint(1) NOT NULL DEFAULT '0',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    // Catat di migrations table
    $pdo->exec("INSERT IGNORE INTO `migrations` (`migration`, `batch`) VALUES ('2026_04_10_075421_create_community_prices_table', 99)");
    echo "  <span style='color:#8b949e'>→ Dicatat di tabel migrations</span>\n";
} else {
    echo "  <span style='color:#8b949e'>⏭ Tabel community_prices sudah ada, skip.</span>\n";
}

// ============================================
// LANGKAH 2: Buat tabel aspirations
// ============================================
echo "\n--- <span style='color:#ffa657'>LANGKAH 2: Tabel aspirations</span> ---\n";
if (!tableExists($pdo, 'aspirations')) {
    runSQL($pdo, "Membuat tabel aspirations", "
        CREATE TABLE `aspirations` (
            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
            `content` text NOT NULL,
            `sender_name` varchar(255) NOT NULL DEFAULT 'Anonim',
            `sender_phone` varchar(255) DEFAULT NULL,
            `location` varchar(255) DEFAULT NULL,
            `is_active` tinyint(1) NOT NULL DEFAULT '0',
            `is_pinned` tinyint(1) NOT NULL DEFAULT '0',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    $pdo->exec("INSERT IGNORE INTO `migrations` (`migration`, `batch`) VALUES ('2026_04_10_075420_create_aspirations_table', 99)");
    echo "  <span style='color:#8b949e'>→ Dicatat di tabel migrations</span>\n";
} else {
    echo "  <span style='color:#8b949e'>⏭ Tabel aspirations sudah ada, skip.</span>\n";
}

// ============================================
// LANGKAH 3: Tambah kolom baru ke materials
// ============================================
echo "\n--- <span style='color:#ffa657'>LANGKAH 3: Kolom baru di tabel materials</span> ---\n";
if (!hasColumn($pdo, 'materials', 'notes')) {
    runSQL($pdo, "Tambah kolom 'notes'", "ALTER TABLE `materials` ADD COLUMN `notes` text NULL AFTER `unit`");
} else { echo "  <span style='color:#8b949e'>⏭ Kolom 'notes' sudah ada.</span>\n"; }

if (!hasColumn($pdo, 'materials', 'last_price')) {
    runSQL($pdo, "Tambah kolom 'last_price'", "ALTER TABLE `materials` ADD COLUMN `last_price` decimal(15,2) NULL AFTER `notes`");
} else { echo "  <span style='color:#8b949e'>⏭ Kolom 'last_price' sudah ada.</span>\n"; }

if (!hasColumn($pdo, 'materials', 'estimated_daily_need')) {
    runSQL($pdo, "Tambah kolom 'estimated_daily_need'", "ALTER TABLE `materials` ADD COLUMN `estimated_daily_need` decimal(10,2) NULL AFTER `last_price`");
} else { echo "  <span style='color:#8b949e'>⏭ Kolom 'estimated_daily_need' sudah ada.</span>\n"; }

// ============================================
// LANGKAH 4: Tambah kolom ke sppgs
// ============================================
echo "\n--- <span style='color:#ffa657'>LANGKAH 4: Kolom baru di tabel sppgs</span> ---\n";
$sppgColumns = [
    'slug'              => "ALTER TABLE `sppgs` ADD COLUMN `slug` varchar(255) NULL UNIQUE AFTER `name`",
    'description'       => "ALTER TABLE `sppgs` ADD COLUMN `description` text NULL AFTER `slug`",
    'image_path'        => "ALTER TABLE `sppgs` ADD COLUMN `image_path` varchar(255) NULL AFTER `description`",
    'manager_name'      => "ALTER TABLE `sppgs` ADD COLUMN `manager_name` varchar(255) NULL AFTER `image_path`",
    'contact_phone'     => "ALTER TABLE `sppgs` ADD COLUMN `contact_phone` varchar(255) NULL AFTER `manager_name`",
    'address'           => "ALTER TABLE `sppgs` ADD COLUMN `address` varchar(255) NULL AFTER `contact_phone`",
    'operational_hours' => "ALTER TABLE `sppgs` ADD COLUMN `operational_hours` varchar(255) NOT NULL DEFAULT '06:00 - 14:00' AFTER `address`",
];
foreach ($sppgColumns as $col => $sql) {
    if (!hasColumn($pdo, 'sppgs', $col)) {
        runSQL($pdo, "Tambah kolom '$col'", $sql);
    } else {
        echo "  <span style='color:#8b949e'>⏭ Kolom '$col' sudah ada.</span>\n";
    }
}

// ============================================
// LANGKAH 5: Tambah kolom ke distribution_routes
// ============================================
echo "\n--- <span style='color:#ffa657'>LANGKAH 5: Kolom baru di tabel distribution_routes</span> ---\n";
$routeColumns = [
    'driver_phone'   => "ALTER TABLE `distribution_routes` ADD COLUMN `driver_phone` varchar(255) NULL",
    'departure_time' => "ALTER TABLE `distribution_routes` ADD COLUMN `departure_time` timestamp NULL",
    'arrival_time'   => "ALTER TABLE `distribution_routes` ADD COLUMN `arrival_time` timestamp NULL",
];
foreach ($routeColumns as $col => $sql) {
    if (!hasColumn($pdo, 'distribution_routes', $col)) {
        runSQL($pdo, "Tambah kolom '$col'", $sql);
    } else {
        echo "  <span style='color:#8b949e'>⏭ Kolom '$col' sudah ada.</span>\n";
    }
}

// ============================================
// LANGKAH 6: Tambah kolom category ke beneficiary_groups
// ============================================
echo "\n--- <span style='color:#ffa657'>LANGKAH 6: Kolom baru di tabel beneficiary_groups</span> ---\n";
if (!hasColumn($pdo, 'beneficiary_groups', 'category')) {
    runSQL($pdo, "Tambah kolom 'category'", "ALTER TABLE `beneficiary_groups` ADD COLUMN `category` varchar(255) NULL AFTER `type`");
} else { echo "  <span style='color:#8b949e'>⏭ Kolom 'category' sudah ada.</span>\n"; }

// ============================================
// LANGKAH 7: Gunakan PHP 8.2 untuk artisan
// ============================================
echo "\n--- <span style='color:#ffa657'>LANGKAH 7: Artisan cache:clear dengan PHP 8.2</span> ---\n";
$php82Paths = [
    '/usr/bin/php8.2',
    '/usr/local/bin/php8.2',
    '/opt/cpanel/ea-php82/root/usr/bin/php',
    '/usr/local/lsws/lsphp82/bin/php',
    '/usr/local/lsws/lsphp81/bin/php',
];
$phpBin = null;
foreach ($php82Paths as $path) {
    if (file_exists($path)) {
        $phpBin = $path;
        break;
    }
}

if ($phpBin) {
    $ver = trim(shell_exec("$phpBin -r 'echo PHP_VERSION;' 2>&1"));
    echo "  PHP binary ditemukan: $phpBin (v$ver)\n";
    $cmd = "cd " . escapeshellarg($laravelRoot) . " && $phpBin artisan optimize:clear 2>&1";
    $out = shell_exec($cmd);
    echo "  Output: $out\n";
} else {
    echo "  <span style='color:#e3b341'>⚠ PHP 8.2 binary tidak ditemukan, skip artisan. Hapus cache manual:</span>\n";
    // Hapus file cache secara manual
    $cacheDirs = [
        $laravelRoot . '/bootstrap/cache',
        $laravelRoot . '/storage/framework/cache',
        $laravelRoot . '/storage/framework/sessions',
        $laravelRoot . '/storage/framework/views',
    ];
    foreach ($cacheDirs as $dir) {
        if (is_dir($dir)) {
            $files = glob($dir . '/*.php') ?: [];
            $files = array_merge($files, glob($dir . '/*.cache') ?: []);
            $cleared = 0;
            foreach ($files as $f) {
                if (basename($f) !== '.gitignore') {
                    @unlink($f);
                    $cleared++;
                }
            }
            echo "  <span style='color:#3fb950'>✅ Cleared $cleared file dari " . basename($dir) . "</span>\n";
        }
    }
}

// ============================================
// LANGKAH 8: Fix permissions
// ============================================
echo "\n--- <span style='color:#ffa657'>LANGKAH 8: Fix Permissions</span> ---\n";
shell_exec("chmod -R 775 " . escapeshellarg($laravelRoot . '/storage') . " 2>&1");
shell_exec("chmod -R 775 " . escapeshellarg($laravelRoot . '/bootstrap/cache') . " 2>&1");
echo "  <span style='color:#3fb950'>✅ Permissions updated</span>\n";

// ============================================
// LANGKAH 9: Tambah porsi_kecil & porsi_besar ke dish_menu
// ============================================
echo "\n--- <span style='color:#ffa657'>LANGKAH 9: Kolom Porsi Ganda (dish_menu)</span> ---\n";
if (tableExists($pdo, 'dish_menu')) {
    if (!hasColumn($pdo, 'dish_menu', 'porsi_kecil')) {
        runSQL($pdo, "Tambah kolom 'porsi_kecil'", "ALTER TABLE `dish_menu` ADD COLUMN `porsi_kecil` int unsigned NOT NULL DEFAULT 0 AFTER `portions` ");
    } else { echo "  <span style='color:#8b949e'>⏭ Kolom 'porsi_kecil' sudah ada.</span>\n"; }
    
    if (!hasColumn($pdo, 'dish_menu', 'porsi_besar')) {
        runSQL($pdo, "Tambah kolom 'porsi_besar'", "ALTER TABLE `dish_menu` ADD COLUMN `porsi_besar` int unsigned NOT NULL DEFAULT 0 AFTER `porsi_kecil` ");
    } else { echo "  <span style='color:#8b949e'>⏭ Kolom 'porsi_besar' sudah ada.</span>\n"; }
} else {
    echo "  <span style='color:#f85149'>❌ Tabel dish_menu tidak ditemukan!</span>\n";
}

// ============================================
// LANGKAH 10: Sinkronisasi Staf SPPG ke Users
// ============================================
echo "\n--- <span style='color:#ffa657'>LANGKAH 10: Sinkron Staf SPPG ke Tabel Users</span> ---\n";
try {
    $sppgs = $pdo->query("SELECT * FROM sppgs")->fetchAll(PDO::FETCH_ASSOC);
    $synced = 0;
    
    foreach ($sppgs as $sppg) {
        $staffMap = [
            'ka_sppg'           => ['phone' => 'phone_ka',       'role' => 'ka_sppg'],
            'pengawas_keuangan' => ['phone' => 'phone_keuangan', 'role' => 'finance_supervisor'],
            'pengawas_gizi'     => ['phone' => 'phone_gizi',     'role' => 'nutrition_supervisor'],
        ];

        foreach ($staffMap as $nameCol => $meta) {
            $name = $sppg[$nameCol] ?? null;
            $rawPhone = $sppg[$meta['phone']] ?? null;
            $role = $meta['role'];

            if (!$name || !$rawPhone) continue;

            // Normalisasi HP
            $phone = preg_replace('/[^0-9]/', '', $rawPhone);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            } elseif (str_starts_with($phone, '8')) {
                $phone = '62' . $phone;
            }

            // Cek apakah user sudah ada
            $stmt = $pdo->prepare("SELECT id FROM users WHERE phone = ? OR email = ?");
            $email = strtolower(str_replace(' ', '', $name)) . "@delphi.or.id";
            $stmt->execute([$phone, $email]);
            $existingUser = $stmt->fetch();

            if (!$existingUser) {
                // Buat user baru
                $insert = $pdo->prepare("INSERT INTO users (name, email, phone, role, sppg_id, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
                $pass = password_hash('password123', PASSWORD_DEFAULT);
                $insert->execute([$name, $email, $phone, $role, $sppg['id'], $pass]);
                echo "  <span style='color:#3fb950'>✅ Created: $name ($role)</span>\n";
                $synced++;
            } else {
                // Update role dan SPPG jika belum sesuai
                $update = $pdo->prepare("UPDATE users SET role = ?, sppg_id = ?, updated_at = NOW() WHERE id = ?");
                $update->execute([$role, $sppg['id'], $existingUser['id']]);
                echo "  <span style='color:#8b949e'>⏭ Updated/Checked: $name</span>\n";
            }
        }
    }
    echo "  <span style='color:#3fb950'>Total sinkronisasi: $synced user baru.</span>\n";
} catch (Exception $e) {
    echo "  <span style='color:#f85149'>❌ Gagal sinkronisasi staf: " . $e->getMessage() . "</span>\n";
}

// ============================================
// HASIL AKHIR: Verifikasi
// ============================================
echo "\n--- <span style='color:#ffa657'>HASIL AKHIR: Verifikasi Tabel</span> ---\n";
$checkTables = ['community_prices', 'aspirations', 'materials', 'sppgs', 'distribution_routes', 'beneficiary_groups', 'dish_menu'];
foreach ($checkTables as $tbl) {
    if (tableExists($pdo, $tbl)) {
        $count = $pdo->query("SELECT COUNT(*) FROM `$tbl`")->fetchColumn();
        echo "  <span style='color:#3fb950'>✅ $tbl</span> ($count records)\n";
    } else {
        echo "  <span style='color:#f85149'>❌ $tbl TIDAK ADA!</span>\n";
    }
}

echo "\n\n<span style='color:#58a6ff'>🎉 SELESAI! Silakan buka https://aladelphi.or.id sekarang.</span>\n";
echo "\n<span style='color:#f85149'>⚠️  PENTING: HAPUS file run_fix.php dari server setelah selesai!</span>\n";
echo '</pre>';
