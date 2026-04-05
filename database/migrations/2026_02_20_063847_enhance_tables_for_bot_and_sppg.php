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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('sppg_id')->nullable()->constrained();
            $table->string('role')->nullable(); // finance, warehouse, aslap, head
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->foreignId('sppg_id')->nullable()->constrained();
        });

        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->foreignId('sppg_id')->nullable()->constrained();
            $table->string('marga')->nullable();
            $table->string('school')->nullable();
            $table->string('posyandu')->nullable();
            $table->text('feedback')->nullable();
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->foreignId('sppg_id')->nullable()->constrained();
        });

        Schema::table('material_logs', function (Blueprint $table) {
            $table->foreignId('sppg_id')->nullable()->constrained();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('sppg_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
