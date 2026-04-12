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
        Schema::table('beneficiary_groups', function (Blueprint $table) {
            // type, porsi_besar, and porsi_kecil already exist from previous steps
            if (!Schema::hasColumn('beneficiary_groups', 'category')) {
                $table->string('category')->nullable()->after('type'); // Guru & staf, Kader posyandu, Anak sekolah, dst
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiary_groups', function (Blueprint $table) {
            $table->dropColumn(['category']);
        });
    }
};
