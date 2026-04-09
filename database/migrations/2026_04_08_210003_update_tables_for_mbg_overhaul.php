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
        Schema::table('beneficiaries', function (Blueprint $table) {
            if (!Schema::hasColumn('beneficiaries', 'type')) {
                $table->string('type')->nullable(); // School, Posyandu
            }
            if (!Schema::hasColumn('beneficiaries', 'portion_large')) {
                $table->integer('portion_large')->default(0);
            }
            if (!Schema::hasColumn('beneficiaries', 'portion_small')) {
                $table->integer('portion_small')->default(0);
            }
            if (!Schema::hasColumn('beneficiaries', 'category')) {
                $table->string('category')->nullable(); // Guru, Kader, etc.
            }
            if (!Schema::hasColumn('beneficiaries', 'sppg_name')) {
                $table->string('sppg_name')->nullable();
            }
        });

        Schema::table('beneficiary_groups', function (Blueprint $table) {
            if (!Schema::hasColumn('beneficiary_groups', 'type')) {
                $table->string('type')->nullable(); // Sekolah, Posyandu
            }
            if (!Schema::hasColumn('beneficiary_groups', 'portion_large')) {
                $table->integer('portion_large')->default(0);
            }
            if (!Schema::hasColumn('beneficiary_groups', 'portion_small')) {
                $table->integer('portion_small')->default(0);
            }
        });

        Schema::table('materials', function (Blueprint $table) {
            if (!Schema::hasColumn('materials', 'category')) {
                $table->string('category')->nullable(); // Karbohidrat, Protein Hewani, etc.
            }
            if (!Schema::hasColumn('materials', 'expiry_date')) {
                $table->date('expiry_date')->nullable();
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'amount_in')) {
                $table->decimal('amount_in', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payments', 'amount_out')) {
                $table->decimal('amount_out', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payments', 'balance')) {
                $table->decimal('balance', 15, 2)->default(0);
            }
        });
        
        Schema::table('menus', function (Blueprint $table) {
             if (!Schema::hasColumn('menus', 'portion_count')) {
                $table->integer('portion_count')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropColumn(['type', 'portion_large', 'portion_small', 'category', 'sppg_name']);
        });
        Schema::table('beneficiary_groups', function (Blueprint $table) {
            $table->dropColumn(['type', 'portion_large', 'portion_small']);
        });
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['category', 'expiry_date']);
        });
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['amount_in', 'amount_out', 'balance']);
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['portion_count']);
        });
    }
};
