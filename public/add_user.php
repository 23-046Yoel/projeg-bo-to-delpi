<?php
/**
 * ====================================================
 * SCRIPT DARURAT v3 - Tambah / Cek User WhatsApp
 * Jalankan via: https://aladelphi.or.id/add_user.php
 * HAPUS FILE INI SETELAH SELESAI!
 * ====================================================
 */

$secret = $_GET['key'] ?? '';
if ($secret !== 'fixboto2024') {
    die('403 Forbidden - Tambahkan ?key=fixboto2024 di URL');
}

echo '<pre style="background:#0d1117;color:#e6edf3;padding:20px;font-size:13px;font-family:monospace;">';
echo "<span style='color:#58a6ff'>👤 Bo To Delpi - User Management Script v3</span>\n";
echo "=============================================\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n\n";

$laravelRoot = '/home/aladelphi.or.id/public_html';
$envContent  = file_get_contents($laravelRoot . '/.env');

preg_match('/DB_HOST=(.+)/',     $envContent, $m); $dbHost = trim($m[1] ?? '127.0.0.1');
preg_match('/DB_DATABASE=(.+)/', $envContent, $m); $dbName = trim($m[1] ?? '');
preg_match('/DB_USERNAME=(.+)/', $envContent, $m); $dbUser = trim($m[1] ?? '');
preg_match('/DB_PASSWORD=(.*)/', $envContent, $m); $dbPass = trim($m[1] ?? '');

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<span style='color:#3fb950'>✅ Koneksi database berhasil!</span>\n\n";
} catch (Exception $e) {
    die("<span style='color:#f85149'>❌ Koneksi GAGAL: " . $e->getMessage() . "</span>\n");
}

// ============================================
// Tampilkan SEMUA USER yang ada
// ============================================
echo "--- <span style='color:#ffa657'>DAFTAR USER SAAT INI</span> ---\n";
$users = $pdo->query("SELECT id, name, phone, role, email FROM users ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
if (empty($users)) {
    echo "  <span style='color:#f85149'>Belum ada user sama sekali di tabel users!</span>\n";
} else {
    printf("  %-4s %-25s %-18s %-15s %-25s\n", 'ID', 'Name', 'Phone', 'Role', 'Email');
    echo "  " . str_repeat('-', 90) . "\n";
    foreach ($users as $u) {
        printf("  %-4s %-25s %-18s %-15s %-25s\n",
            $u['id'],
            substr($u['name'] ?? '-', 0, 24),
            $u['phone'] ?? '-',
            $u['role'] ?? '-',
            substr($u['email'] ?? '-', 0, 24)
        );
    }
}

// ============================================
// Tambah user via GET parameter
// Contoh: ?key=fixboto2024&add=1&phone=6281324697114&name=Admin&role=admin
// ============================================
echo "\n--- <span style='color:#ffa657'>TAMBAH / UPDATE USER</span> ---\n";

if (isset($_GET['add'])) {
    $newPhone = preg_replace('/[^0-9]/', '', $_GET['phone'] ?? '');
    $newName  = trim($_GET['name'] ?? 'Admin');
    $newEmail = trim($_GET['email'] ?? ($newPhone . '@aladelphi.or.id'));
    $newRole  = trim($_GET['role'] ?? 'admin');

    // Normalize phone
    if (str_starts_with($newPhone, '620')) {
        $newPhone = '62' . substr($newPhone, 3);
    } elseif (str_starts_with($newPhone, '0')) {
        $newPhone = '62' . substr($newPhone, 1);
    } elseif (str_starts_with($newPhone, '8')) {
        $newPhone = '62' . $newPhone;
    }

    if (!$newPhone) {
        echo "  <span style='color:#f85149'>❌ Parameter 'phone' tidak valid!</span>\n";
    } else {
        // Cek apakah sudah ada
        $existing = $pdo->prepare("SELECT id, role FROM users WHERE phone = ?");
        $existing->execute([$newPhone]);
        $found = $existing->fetch(PDO::FETCH_ASSOC);

        if ($found) {
            // Update role jika sudah ada
            $upd = $pdo->prepare("UPDATE users SET role = ?, name = ?, updated_at = NOW() WHERE phone = ?");
            $upd->execute([$newRole, $newName, $newPhone]);
            echo "  <span style='color:#e3b341'>⚠ User sudah ada (ID: {$found['id']}), role diupdate ke: $newRole</span>\n";
        } else {
            // Insert user baru
            $ins = $pdo->prepare("
                INSERT INTO users (name, email, phone, role, password, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, NOW(), NOW())
            ");
            // Password hash dummy (login pakai OTP WhatsApp, bukan password)
            $dummyHash = password_hash(uniqid('', true), PASSWORD_BCRYPT);
            $ins->execute([$newName, $newEmail, $newPhone, $newRole, $dummyHash]);
            $newId = $pdo->lastInsertId();
            echo "  <span style='color:#3fb950'>✅ User baru berhasil ditambahkan!</span>\n";
            echo "  ID     : $newId\n";
            echo "  Nama   : $newName\n";
            echo "  Phone  : $newPhone\n";
            echo "  Role   : $newRole\n";
            echo "  Email  : $newEmail\n";
        }
    }
} else {
    echo "  <span style='color:#8b949e'>ℹ Untuk menambah user, buka URL berikut:</span>\n\n";
    echo "  <span style='color:#79c0ff'>https://aladelphi.or.id/add_user.php?key=fixboto2024&add=1</span>\n";
    echo "  <span style='color:#79c0ff'>  &amp;phone=<b>6281324697114</b>&amp;name=<b>Nama+Admin</b>&amp;role=<b>admin</b></span>\n\n";
    echo "  Role yang tersedia: admin, ka_sppg, pengawas_gizi, pengawas_keuangan, aslap, volunteer, warehouse, qc\n";
    echo "\n  <span style='color:#e3b341'>Ganti nilai phone, name, dan role sesuai kebutuhan!</span>\n";
}

// ============================================
// Tampilkan ulang daftar user setelah perubahan
// ============================================
if (isset($_GET['add'])) {
    echo "\n--- <span style='color:#ffa657'>DAFTAR USER SETELAH UPDATE</span> ---\n";
    $users = $pdo->query("SELECT id, name, phone, role FROM users ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
    printf("  %-4s %-25s %-18s %-15s\n", 'ID', 'Name', 'Phone', 'Role');
    echo "  " . str_repeat('-', 65) . "\n";
    foreach ($users as $u) {
        printf("  %-4s %-25s %-18s %-15s\n",
            $u['id'],
            substr($u['name'] ?? '-', 0, 24),
            $u['phone'] ?? '-',
            $u['role'] ?? '-'
        );
    }
}

echo "\n\n<span style='color:#f85149'>⚠️  PENTING: HAPUS file add_user.php dari server setelah selesai!</span>\n";
echo '</pre>';
