<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lpj_sppgs', function (Blueprint $table) {
            $table->foreignId('sppg_id')->nullable()->after('id')
                  ->constrained('sppgs')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lpj_sppgs', function (Blueprint $table) {
            $table->dropForeign(['sppg_id']);
            $table->dropColumn('sppg_id');
        });
    }
};
