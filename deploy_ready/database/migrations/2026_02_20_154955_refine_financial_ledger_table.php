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
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('amount_in', 15, 2)->default(0)->after('amount');
            $table->decimal('amount_out', 15, 2)->default(0)->after('amount_in');
            $table->decimal('balance_after', 15, 2)->default(0)->after('amount_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
