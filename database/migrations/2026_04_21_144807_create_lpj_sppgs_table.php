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
        Schema::create('lpj_sppgs', function (Blueprint $table) {
            $table->id();
            $table->date('period_start');
            $table->date('period_end');
            $table->integer('target_peserta')->default(0);
            $table->integer('realisasi_peserta')->default(0);
            $table->integer('target_pendidik')->default(0);
            $table->integer('realisasi_pendidik')->default(0);
            $table->integer('target_3b')->default(0);
            $table->integer('realisasi_3b')->default(0);
            $table->decimal('anggaran_bahan', 15, 2)->default(0);
            $table->decimal('realisasi_bahan', 15, 2)->default(0);
            $table->decimal('anggaran_ops', 15, 2)->default(0);
            $table->decimal('realisasi_ops', 15, 2)->default(0);
            $table->decimal('anggaran_insentif', 15, 2)->default(0);
            $table->decimal('realisasi_insentif', 15, 2)->default(0);
            $table->string('ketua_yayasan')->nullable();
            $table->string('ppk_nama')->nullable();
            $table->string('head_sppg_nama')->nullable();
            $table->date('report_date');
            $table->json('organoleptik_data')->nullable();
            $table->json('buku_bantu_bahan')->nullable();
            $table->json('buku_bantu_ops')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpj_sppgs');
    }
};
