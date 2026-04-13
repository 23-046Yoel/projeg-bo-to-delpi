<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = \App\Models\News::count();
echo "Current News Count: $count\n";

if ($count > 10) {
    $toDelete = $count - 10;
    $ids = \App\Models\News::orderBy('created_at', 'asc')->take($toDelete)->pluck('id');
    \App\Models\News::whereIn('id', $ids)->delete();
    echo "Deleted $toDelete old news items. Remaining: 10\n";
} else {
    echo "Count is already <= 10. No deletion needed.\n";
}
