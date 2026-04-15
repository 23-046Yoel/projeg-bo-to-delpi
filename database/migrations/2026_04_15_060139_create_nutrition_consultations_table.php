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
        Schema::create('nutrition_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('age');
            $table->string('gender');
            $table->decimal('weight', 5, 2);
            $table->decimal('height', 5, 2);
            $table->string('goal');
            $table->text('medical_history')->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_consultations');
    }
};
