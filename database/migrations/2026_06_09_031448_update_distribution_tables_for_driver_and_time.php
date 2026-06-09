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
            $table->foreignId('driver_2_id')->nullable()->after('driver_id')->constrained('users')->onDelete('set null');
            $table->string('vehicle_name')->nullable()->after('driver_phone');
        });

        Schema::table('distribution_stops', function (Blueprint $table) {
            $table->string('scheduled_time')->nullable()->after('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distribution_routes', function (Blueprint $table) {
            $table->dropForeign(['driver_2_id']);
            $table->dropColumn(['driver_2_id', 'vehicle_name']);
        });

        Schema::table('distribution_stops', function (Blueprint $table) {
            $table->dropColumn(['scheduled_time']);
        });
    }
};
