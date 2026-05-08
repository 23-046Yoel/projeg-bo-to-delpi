<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$phones = [
    '6281265893453', '081265893453', '+6281265893453', '0812-6589-3453', '+62 812-6589-3453',
    '6283169597457', '083169597457', '+6283169597457', '62 831-6959-7457'
];

$users = \App\Models\User::whereIn('phone', $phones)->get(['name', 'phone', 'role']);
echo json_encode($users);
