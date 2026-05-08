<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = [
    ['email' => 'yoelflemming8@gmail.com', 'name' => 'Yoel Flemming'],
    ['email' => 'grasellatobing1611@gmail.com', 'name' => 'Grasella Tobing'],
    ['email' => 'sarahmanuellalumbangaol21@gmail.com', 'name' => 'Sarah Manuella']
];

foreach ($users as $u) {
    \App\Models\User::updateOrCreate(
        ['email' => $u['email']],
        [
            'name' => $u['name'],
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'master admin', // assuming master admin role
            'email_verified_at' => now(),
            'phone' => rand(1000000000, 9999999999), // Dummy phone if required
        ]
    );
}

echo "Users created successfully.\n";
