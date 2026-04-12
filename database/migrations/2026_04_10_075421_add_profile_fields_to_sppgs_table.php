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
            $table->string('slug')->unique()->nullable()->after('name');
            $table->text('description')->nullable()->after('slug');
            $table->string('image_path')->nullable()->after('description');
            $table->string('manager_name')->nullable()->after('image_path');
            $table->string('contact_phone')->nullable()->after('manager_name');
            $table->string('address')->nullable()->after('contact_phone');
            $table->string('operational_hours')->default('06:00 - 14:00')->after('address'); // Jam operasional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sppgs', function (Blueprint $table) {
            //
        });
    }
};
