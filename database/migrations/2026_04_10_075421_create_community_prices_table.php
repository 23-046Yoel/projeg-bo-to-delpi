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
        Schema::create('community_prices', function (Blueprint $table) {
            $table->id();
            $table->string('item_name'); // Nama bahan pangan
            $table->decimal('price', 12, 2); // Harga
            $table->string('unit')->default('kg'); // satuan
            $table->string('reporter_name')->default('Anonim');
            $table->string('reporter_phone')->nullable();
            $table->string('location'); // Nama pasar / lokasi
            $table->string('sumber_link')->nullable(); // Link referensi harga (opsional)
            $table->integer('likes')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_prices');
    }
};
