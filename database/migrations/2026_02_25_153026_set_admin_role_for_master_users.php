<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \App\Models\User::whereIn('email', [
            'yoelflemming8@gmail.com',
            'silverius1008@gmail.com'
        ])->update(['role' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\User::whereIn('email', [
            'yoelflemming8@gmail.com',
            'silverius1008@gmail.com'
        ])->update(['role' => null]);
    }
};
