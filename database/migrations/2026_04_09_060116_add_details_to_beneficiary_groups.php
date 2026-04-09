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
            $table->unsignedInteger('count_siswa')->nullable()->default(0);
            $table->unsignedInteger('count_guru')->nullable()->default(0);
            $table->unsignedInteger('count_hamil')->nullable()->default(0);
            $table->unsignedInteger('count_menyusui')->nullable()->default(0);
            $table->unsignedInteger('count_balita')->nullable()->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('beneficiary_groups', function (Blueprint $table) {
            $table->dropColumn(['count_siswa', 'count_guru', 'count_hamil', 'count_menyusui', 'count_balita']);
        });
    }
};
