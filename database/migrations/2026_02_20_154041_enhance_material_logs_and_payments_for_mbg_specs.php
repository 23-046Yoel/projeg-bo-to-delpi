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
        Schema::table('material_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('material_logs', 'color')) $table->string('color')->nullable();
            if (!Schema::hasColumn('material_logs', 'aroma')) $table->string('aroma')->nullable();
            if (!Schema::hasColumn('material_logs', 'temperature')) $table->string('temperature')->nullable();
            if (!Schema::hasColumn('material_logs', 'storage_location')) $table->string('storage_location')->nullable();
        });

        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'transaction_type')) $table->string('transaction_type')->nullable();
            if (!Schema::hasColumn('payments', 'cash_type')) $table->string('cash_type')->nullable();
            if (!Schema::hasColumn('payments', 'status')) $table->string('status')->default('pending');
            if (!Schema::hasColumn('payments', 'proof_path')) $table->string('proof_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_logs', function (Blueprint $table) {
            $table->dropColumn(['color', 'aroma', 'temperature', 'storage_location']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['transaction_type', 'cash_type', 'status', 'proof_path']);
        });
    }
};
