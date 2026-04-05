<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->foreignId('beneficiary_group_id')->nullable()->constrained()->onDelete('set null');
            $table->string('category')->nullable(); // Breastfeeding, Pregnant, Toddler, School Child
            $table->string('gender')->nullable()->change(); // Already added in previous migration but making change just in case
            $table->date('dob')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropForeign(['beneficiary_group_id']);
            $table->dropColumn(['beneficiary_group_id', 'category']);
        });
    }
};
