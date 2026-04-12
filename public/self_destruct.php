<?php
/**
 * 💣 SELF DESTRUCT SCRIPT
 * Keamanan: Menghapus semua file script pembantu setelah perbaikan selesai.
 */
$secret = $_GET['key'] ?? '';
if ($secret !== 'fixboto2024') die('403 Forbidden');

$filesToDelete = [
    'run_fix.php',
    'add_user.php',
    'cek_users.php',
    'cek_wa.php',
    'git_pull.php',
    'merge_karangrejo.php',
    'cek_sppg.php',
    'find_sppg_usage.php',
    'update_meylinda.php',
    'cek_error.php',
    'import_relawan.php',
    'import_karangrejo.php',
    'check_menus_table.php',
    'self_destruct.php' // Menghapus diri sendiri juga di akhir
];

echo '<pre style="background:#0d1117;color:#e6edf3;padding:20px;font-size:13px;font-family:monospace;">';
echo "🧨 MEMULAI PEMBERSIHAN TOTAL\n";
echo "============================\n\n";

foreach ($filesToDelete as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "🗑️ Terhapus: $file\n";
        } else {
            echo "❌ Gagal hapus: $file (Cek permission)\n";
        }
    } else {
        echo "⚪ Tidak ditemukan: $file\n";
    }
}

echo "\n<span style='color:#3fb950; font-weight:bold;'>✅ SEMUA BERSIH! Website Anda sekarang aman.</span>\n";
echo "Halaman ini akan error jika Anda refresh karena filenya sudah terhapus.";
echo '</pre>';
