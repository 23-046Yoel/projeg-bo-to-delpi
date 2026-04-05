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
        Schema::create('mbg_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beneficiary_id')->constrained();
            $table->decimal('quantity', 10, 2);
            $table->timestamp('distributed_at');
            $table->foreignId('sppg_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mbg_distributions');
    }
};
