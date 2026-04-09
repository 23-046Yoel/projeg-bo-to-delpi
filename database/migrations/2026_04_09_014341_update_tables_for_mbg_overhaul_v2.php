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
        // Add sppg_id to various tables for scoping
        $tables = ['beneficiaries', 'beneficiary_groups', 'menus', 'materials', 'payments'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'sppg_id')) {
                    $table->foreignId('sppg_id')->nullable()->constrained('sppgs')->onDelete('cascade');
                }
            });
        }

        // Add transaction fields to payments
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'transaction_type')) {
                $table->string('transaction_type')->nullable(); // Bahan Baku, Operasional, Insentif, Bantuan Pemerintah
            }
            if (!Schema::hasColumn('payments', 'cash_type')) {
                $table->string('cash_type')->nullable(); // Virtual Akun, Kas Kecil
            }
            if (!Schema::hasColumn('payments', 'proof_file')) {
                $table->string('proof_file')->nullable();
            }
            if (!Schema::hasColumn('payments', 'description')) {
                $table->text('description')->nullable();
            }
        });

        // Add unit to materials
        Schema::table('materials', function (Blueprint $table) {
            if (!Schema::hasColumn('materials', 'unit')) {
                $table->string('unit')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['unit']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['transaction_type', 'cash_type', 'proof_file', 'description']);
        });

        $tables = ['payments', 'materials', 'menus', 'beneficiary_groups', 'beneficiaries'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['sppg_id']);
                $table->dropColumn('sppg_id');
            });
        }
    }
};
