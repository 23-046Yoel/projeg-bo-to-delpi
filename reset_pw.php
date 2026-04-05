<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::find(2);
if ($user) {
    $user->password = Hash::make('Admin1234');
    $user->save();
    echo "Password untuk " . $user->email . " berhasil diubah menjadi: Admin1234";
} else {
    echo "User tidak ditemukan.";
}
