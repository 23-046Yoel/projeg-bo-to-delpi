<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$logCount = \App\Models\MaterialLog::count();
\App\Models\MaterialLog::query()->delete();
\App\Models\Material::query()->update(['stock' => 0]);

echo "Total Reset Complete:\n";
echo "- $logCount material log entries have been deleted.\n";
echo "- All material stocks have been reset to 0.\n";
