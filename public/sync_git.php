<?php
/**
 * FORCE GIT PULL SCRIPT for Bo To Delpi
 */
$key = $_GET['key'] ?? '';
if ($key !== 'sync2024') {
    die('Unauthorized access.');
}

echo "<pre style='background:#0d1117;color:#e6edf3;padding:20px;border-radius:8px;'>";
echo "🚀 <b>Git Pull Force Sync Starting...</b>\n\n";

// Path to project root
$path = dirname(__DIR__);
chdir($path);

echo "Current Directory: " . getcwd() . "\n";

// Try to pull from origin main
$commands = [
    'git reset --hard origin/main 2>&1',
    'git pull origin main 2>&1',
    'php artisan optimize:clear 2>&1'
];

foreach ($commands as $cmd) {
    echo "Running: $cmd\n";
    $output = shell_exec($cmd);
    echo "$output\n";
}

echo "\n✅ <b>Sync Finished!</b>\n";
echo "Please check the website now.\n";
echo "</pre>";
