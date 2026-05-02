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
        Schema::create('production_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->timestamp('prep_start')->nullable();
            $table->timestamp('prep_end')->nullable();
            $table->timestamp('proc_start')->nullable();
            $table->timestamp('proc_end')->nullable();
            $table->timestamp('port_start')->nullable();
            $table->timestamp('port_end')->nullable();
            $table->string('port_all_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_logs');
    }
};
