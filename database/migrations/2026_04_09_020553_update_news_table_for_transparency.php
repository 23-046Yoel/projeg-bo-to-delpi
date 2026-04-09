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
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'sppg_id')) {
                $table->foreignId('sppg_id')->nullable()->constrained('sppgs')->onDelete('cascade');
            }
            if (!Schema::hasColumn('news', 'image_path')) {
                $table->string('image_path')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign(['sppg_id']);
            $table->dropColumn(['sppg_id', 'image_path']);
        });
    }
};
