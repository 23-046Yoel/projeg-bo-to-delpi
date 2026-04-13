<?php
$secret = $_GET['key'] ?? '';
if ($secret !== 'fixboto2024') die('403 Forbidden');

echo '<pre style="background:#0d1117;color:#e6edf3;padding:20px;font-size:13px;font-family:monospace;">';
echo "🔄 Git Pull - Server Update\n";
echo "============================\n\n";

$root = '/home/aladelphi.or.id/public_html';
$output = shell_exec("cd $root && git pull origin main 2>&1");
echo $output . "\n";

// Clear cache with PHP 8.2
$php = '/usr/local/lsws/lsphp82/bin/php';
if (file_exists($php)) {
    echo "\nRunning Migrations:\n";
    $out_mig = shell_exec("cd $root && $php artisan migrate --force 2>&1");
    echo $out_mig . "\n";

    $out2 = shell_exec("cd $root && $php artisan optimize:clear 2>&1");
    echo "\nCache cleared:\n" . $out2;
}

echo "\n✅ Selesai! Perubahan sudah aktif di server.\n";
echo '</pre>';
