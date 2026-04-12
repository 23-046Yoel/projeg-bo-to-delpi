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
        Schema::table('dish_menu', function (Blueprint $table) {
            if (!Schema::hasColumn('dish_menu', 'porsi_kecil')) {
                $table->unsignedInteger('porsi_kecil')->default(0)->after('portions');
            }
            if (!Schema::hasColumn('dish_menu', 'porsi_besar')) {
                $table->unsignedInteger('porsi_besar')->default(0)->after('porsi_kecil');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dish_menu', function (Blueprint $table) {
            $table->dropColumn(['porsi_kecil', 'porsi_besar']);
        });
    }
};
