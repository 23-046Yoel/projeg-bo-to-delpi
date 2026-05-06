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
        Schema::table('production_logs', function (Blueprint $table) {
            $table->decimal('proc_temp', 5, 2)->nullable()->after('proc_end');
            $table->string('proc_all_photo')->nullable()->after('proc_temp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_logs', function (Blueprint $table) {
            $table->dropColumn(['proc_temp', 'proc_all_photo']);
        });
    }
};
