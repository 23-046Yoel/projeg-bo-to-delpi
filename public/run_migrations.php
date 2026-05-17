<?php
$secret = $_GET['key'] ?? '';
if ($secret !== 'fixboto2024') die('403 Forbidden');

echo '<pre style="background:#0d1117;color:#e6edf3;padding:20px;font-size:13px;font-family:monospace;">';
echo "🛠️ FORCE UPDATE & MIGRATE - ROOT DIRECTORY\n";
echo "==========================================\n\n";

$root = '/home/aladelphi.or.id/public_html';

// 1. Git Status
echo "--- 1. Git Status ---\n";
$out = shell_exec("cd $root && git status 2>&1");
echo $out . "\n";

// 2. Fetch and Reset Hard
echo "--- 2. Fetch and Reset Hard ---\n";
$out = shell_exec("cd $root && git fetch --all 2>&1 && git reset --hard origin/main 2>&1");
echo $out . "\n";

// 3. Current Commit
$commit = trim(shell_exec("cd $root && git rev-parse HEAD 2>&1"));
echo "Current Commit: $commit\n\n";

// 4. Run Migrations
echo "--- 4. Run Migrations ---\n";
$php = '/usr/local/lsws/lsphp82/bin/php';
if (file_exists($php)) {
    $out = shell_exec("cd $root && $php artisan migrate --force 2>&1");
    echo $out . "\n";
    
    $out = shell_exec("cd $root && $php artisan optimize:clear 2>&1");
    echo "Cache cleared:\n" . $out . "\n";
} else {
    echo "PHP binary not found at $php\n";
}

echo "\n✅ Selesai!\n";
echo '</pre>';
