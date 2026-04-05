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
        Schema::create('distribution_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistant_id')->constrained('users');
            $table->foreignId('driver_id')->constrained('users');
            $table->foreignId('sppg_id')->constrained();
            $table->date('date');
            $table->enum('status', ['planned', 'active', 'completed'])->default('planned');
            $table->timestamp('departure_time')->nullable();
            $table->string('departure_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_routes');
    }
};
