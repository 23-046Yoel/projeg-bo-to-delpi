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
        Schema::table('sppgs', function (Blueprint $table) {
            $table->string('code')->nullable()->after('id');
            $table->string('ka_sppg')->nullable()->after('name');
            $table->string('phone_ka')->nullable()->after('ka_sppg');
            $table->string('pengawas_keuangan')->nullable()->after('phone_ka');
            $table->string('phone_keuangan')->nullable()->after('pengawas_keuangan');
            $table->string('pengawas_gizi')->nullable()->after('phone_keuangan');
            $table->string('phone_gizi')->nullable()->after('pengawas_gizi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sppgs', function (Blueprint $table) {
            $table->dropColumn(['code', 'ka_sppg', 'phone_ka', 'pengawas_keuangan', 'phone_keuangan', 'pengawas_gizi', 'phone_gizi']);
        });
    }
};
