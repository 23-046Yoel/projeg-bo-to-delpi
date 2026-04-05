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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('type'); // e.g., 'Kualitas Makanan', 'Pengiriman', 'Layanan', etc.
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->string('status')->default('Menunggu'); // 'Menunggu', 'Diproses', 'Selesai'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
