<?php
/**
 * Fix Storage Directories & Permissions
 */
$key = $_GET['key'] ?? '';
if ($key !== 'sync2024') die('Unauthorized.');

$base = dirname(__DIR__) . '/storage/framework';
$dirs = [
    $base . '/sessions',
    $base . '/views',
    $base . '/cache',
    dirname(__DIR__) . '/storage/logs',
    dirname(__DIR__) . '/bootstrap/cache',
];

echo "<h1>Fixing Storage...</h1>";

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
        echo "✅ Created: $dir<br>";
    } else {
        echo "ℹ️ Exists: $dir<br>";
    }
    // Set permission
    chmod($dir, 0775);
}

echo "<br><b>Beres! Coba sekarang buka website utamanya mas.</b>";
