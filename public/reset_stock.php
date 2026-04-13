<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = \App\Models\Material::count();
\App\Models\Material::query()->update(['stock' => 0]);
echo "Stock for all $count materials has been reset to 0 on the server.\n";
