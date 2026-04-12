<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sppg;

$sppgs = Sppg::where('name', 'like', '%Karang Rejo%')->get();
foreach ($sppgs as $s) {
    echo "ID: {$s->id} - Name: {$s->name} - Code: {$s->code}" . PHP_EOL;
}
