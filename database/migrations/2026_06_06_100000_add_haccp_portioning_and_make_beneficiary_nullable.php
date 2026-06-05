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
        Schema::table('daily_lpjs', function (Blueprint $table) {
            if (!Schema::hasColumn('daily_lpjs', 'haccp_portioning')) {
                $table->json('haccp_portioning')->nullable()->after('haccp_processing');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('beneficiary_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_lpjs', function (Blueprint $table) {
            if (Schema::hasColumn('daily_lpjs', 'haccp_portioning')) {
                $table->dropColumn('haccp_portioning');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('beneficiary_id')->nullable(false)->change();
        });
    }
};
