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
        Schema::create('material_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sppg_id')->constrained();
            $table->foreignId('material_id')->constrained();
            $table->decimal('quantity', 15, 4);
            $table->string('source_location'); // Gudang Kering / Gudang Basah
            $table->string('temperature_received')->nullable();
            $table->timestamp('prep_completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requests');
    }
};
