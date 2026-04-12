<?php
$secret = $_GET['key'] ?? '';
if ($secret !== 'fixboto2024') die('403 Forbidden');

$laravelRoot = '/home/aladelphi.or.id/public_html';
$logPath = $laravelRoot . '/storage/logs/laravel.log';

echo '<pre style="background:#0d1117;color:#e6edf3;padding:20px;font-size:13px;font-family:monospace;">';
echo "🕵️ CARI ERROR TERBARU\n";
echo "============================\n\n";

if (!file_exists($logPath)) {
    die("Log file not found at: $logPath");
}

$logs = shell_exec("tail -n 100 " . escapeshellarg($logPath));
echo htmlspecialchars($logs);

echo '</pre>';
