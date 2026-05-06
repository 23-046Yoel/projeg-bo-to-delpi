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
        Schema::create('daily_lpjs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('sppg_id')->constrained()->onDelete('cascade');
            $table->date('date');
            
            // Ringkasan Kegiatan
            $table->decimal('total_production', 10, 2)->default(0);
            $table->decimal('total_distribution', 10, 2)->default(0);
            $table->decimal('leftover_food', 10, 2)->default(0);
            $table->decimal('food_waste', 10, 2)->default(0);
            $table->decimal('total_expenditure', 15, 2)->default(0);
            
            // Complex data tables stored as JSON
            $table->json('material_receipts')->nullable(); // Penerimaan Bahan Baku
            $table->json('haccp_preparation')->nullable(); // HACCP Produksi (Persiapan)
            $table->json('haccp_processing')->nullable();  // HACCP Produksi (Pengolahan)
            $table->json('distribution_data')->nullable(); // Distribusi
            
            // Keuangan Harian (Virtual & Cash)
            $table->decimal('initial_balance_virtual', 15, 2)->default(0);
            $table->decimal('initial_balance_cash', 15, 2)->default(0);
            $table->decimal('expenditure_materials_virtual', 15, 2)->default(0);
            $table->decimal('expenditure_materials_cash', 15, 2)->default(0);
            $table->decimal('expenditure_ops_salary_virtual', 15, 2)->default(0);
            $table->decimal('expenditure_ops_salary_cash', 15, 2)->default(0);
            $table->decimal('expenditure_ops_gas_virtual', 15, 2)->default(0);
            $table->decimal('expenditure_ops_gas_cash', 15, 2)->default(0);
            $table->decimal('expenditure_ops_electricity_virtual', 15, 2)->default(0);
            $table->decimal('expenditure_ops_electricity_cash', 15, 2)->default(0);
            $table->decimal('expenditure_ops_admin_virtual', 15, 2)->default(0);
            $table->decimal('expenditure_ops_admin_cash', 15, 2)->default(0);
            $table->decimal('expenditure_incentive_virtual', 15, 2)->default(0);
            $table->decimal('expenditure_incentive_cash', 15, 2)->default(0);
            $table->decimal('final_balance_virtual', 15, 2)->default(0);
            $table->decimal('final_balance_cash', 15, 2)->default(0);
            
            $table->text('conclusion')->nullable();
            $table->json('signatures')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_lpjs');
    }
};
