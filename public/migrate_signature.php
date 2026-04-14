<?php
/**
 * ONE-TIME: Add signature_path column to users table + create storage symlink
 */
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$key = $_GET['key'] ?? '';
if ($key !== 'migrate24') {
    die('Unauthorized.');
}

echo "<pre style='background:#f0fdf4;color:#166534;padding:20px;border-radius:12px;font-family:monospace;border:2px solid #22c55e;'>";
echo "🛠️ <b>DB MIGRATION: ADD SIGNATURE COLUMN</b>\n\n";

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

// 1. Add signature_path to users
if (!Schema::hasColumn('users', 'signature_path')) {
    Schema::table('users', function (Blueprint $table) {
        $table->string('signature_path')->nullable()->after('password');
    });
    echo "✅ Kolom <b>signature_path</b> berhasil ditambahkan ke tabel users.\n";
} else {
    echo "ℹ️  Kolom <b>signature_path</b> sudah ada.\n";
}

// 2. Make storage symlink
try {
    Artisan::call('storage:link');
    echo "✅ Storage symlink berhasil dibuat.\n";
} catch (Exception $e) {
    echo "⚠️  Storage symlink: " . $e->getMessage() . "\n";
}

echo "\n✅ <b>SELESAI! Silakan refresh website.</b>\n";
echo "</pre>";
