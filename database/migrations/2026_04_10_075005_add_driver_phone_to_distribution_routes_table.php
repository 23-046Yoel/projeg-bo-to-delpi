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
        Schema::table('distribution_routes', function (Blueprint $table) {
            if (!Schema::hasColumn('distribution_routes', 'driver_phone')) {
                $table->string('driver_phone')->nullable()->after('driver_id');
            }
            if (!Schema::hasColumn('distribution_routes', 'departure_time')) {
                $table->timestamp('departure_time')->nullable()->after('status');
            }
            if (!Schema::hasColumn('distribution_routes', 'arrival_time')) {
                $table->timestamp('arrival_time')->nullable()->after('departure_time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distribution_routes', function (Blueprint $table) {
            $table->dropColumn(['driver_phone', 'departure_time', 'arrival_time']);
        });
    }
};
