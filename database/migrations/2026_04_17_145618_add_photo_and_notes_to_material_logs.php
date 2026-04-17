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
            if (!Schema::hasColumn('material_logs', 'notes')) {
                $table->text('notes')->nullable();
            }
            if (!Schema::hasColumn('material_logs', 'photo_path')) {
                $table->string('photo_path')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_logs', function (Blueprint $table) {
            $table->dropColumn(['notes', 'photo_path']);
        });
    }
};
