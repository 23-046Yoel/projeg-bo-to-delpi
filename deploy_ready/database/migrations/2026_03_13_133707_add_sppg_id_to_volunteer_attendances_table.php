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
        Schema::table('volunteer_attendances', function (Blueprint $table) {
            $table->foreignId('sppg_id')->nullable()->after('user_id')->constrained('sppgs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteer_attendances', function (Blueprint $table) {
            $table->dropForeign(['sppg_id']);
            $table->dropColumn('sppg_id');
        });
    }
};
