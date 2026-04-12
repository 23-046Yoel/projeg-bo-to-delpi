<?php
$secret = $_GET['key'] ?? '';
if ($secret !== 'fixboto2024') die('403 Forbidden');

echo '<pre style="background:#0d1117;color:#e6edf3;padding:20px;font-size:13px;font-family:monospace;">';
echo "🔍 Cek Error Log & WhatsApp Service\n";
echo "=====================================\n\n";

$root = '/home/aladelphi.or.id/public_html';

// Baca .env
$env = file_get_contents($root . '/.env');
preg_match('/KIRIMI_USER_CODE=(.+)/', $env, $m); $userCode = trim($m[1] ?? '');
preg_match('/KIRIMI_SECRET=(.+)/', $env, $m);    $secret2  = trim($m[1] ?? '');
preg_match('/KIRIMI_DEVICE_ID=(.+)/', $env, $m); $deviceId = trim($m[1] ?? '');

echo "--- KIRIMI CONFIG ---\n";
echo "User Code : $userCode\n";
echo "Device ID : $deviceId\n";
echo "Secret    : " . substr($secret2, 0, 10) . "...\n\n";

// Test kirim pesan via Kirimi API langsung
echo "--- TEST KIRIM PESAN KE 6285353325352 ---\n";
$targetPhone = '6285353325352';
$message = "*[TEST]* Script cek koneksi Kirimi.id\nWaktu: " . date('d/m/Y H:i:s');

$url = "https://api.kirimi.id/v2/wa/send-message";
$payload = json_encode([
    'user_code' => $userCode,
    'secret'    => $secret2,
    'device_id' => $deviceId,
    'to'        => $targetPhone,
    'message'   => $message,
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

echo "HTTP Code : $httpCode\n";
echo "Response  : $result\n";
if ($curlErr) echo "CURL Error: $curlErr\n";

echo "\n--- LOG LARAVEL TERBARU ---\n";
$log = '/home/aladelphi.or.id/public_html/storage/logs/laravel.log';
if (file_exists($log)) {
    $lines = file($log);
    $last = array_slice($lines, -30);
    foreach ($last as $line) echo htmlspecialchars($line);
} else {
    echo "Log tidak ditemukan\n";
}
echo '</pre>';
