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
        Schema::table('materials', function (Blueprint $table) {
            if (!Schema::hasColumn('materials', 'notes')) {
                $table->text('notes')->nullable()->after('unit'); // Catatan/keterangan bahan
            }
            if (!Schema::hasColumn('materials', 'last_price')) {
                $table->decimal('last_price', 15, 2)->nullable()->after('notes'); // Harga beli terakhir
            }
            if (!Schema::hasColumn('materials', 'estimated_daily_need')) {
                $table->decimal('estimated_daily_need', 10, 2)->nullable()->after('last_price'); // Estimasi kebutuhan per hari
            }
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['notes', 'last_price', 'estimated_daily_need']);
        });
    }
};
