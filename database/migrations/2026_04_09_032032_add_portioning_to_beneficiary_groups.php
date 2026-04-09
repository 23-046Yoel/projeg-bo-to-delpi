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
            if (!Schema::hasColumn('beneficiary_groups', 'porsi_besar')) {
                $table->unsignedInteger('porsi_besar')->nullable()->comment('Jumlah porsi besar (siswa/balita)');
            }
            if (!Schema::hasColumn('beneficiary_groups', 'porsi_kecil')) {
                $table->unsignedInteger('porsi_kecil')->nullable()->comment('Jumlah porsi kecil (guru/staff)');
            }
            if (!Schema::hasColumn('beneficiary_groups', 'type')) {
                $table->string('type')->default('sekolah')->comment('sekolah atau posyandu');
            }
        });
    }

    public function down(): void
    {
        Schema::table('beneficiary_groups', function (Blueprint $table) {
            $table->dropColumn(['porsi_besar', 'porsi_kecil', 'type']);
        });
    }
};
