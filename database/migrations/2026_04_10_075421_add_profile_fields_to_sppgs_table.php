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
            if (!Schema::hasColumn('sppgs', 'slug')) {
                $table->string('slug')->unique()->nullable()->after('name');
            }
            if (!Schema::hasColumn('sppgs', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('sppgs', 'image_path')) {
                $table->string('image_path')->nullable()->after('description');
            }
            if (!Schema::hasColumn('sppgs', 'manager_name')) {
                $table->string('manager_name')->nullable()->after('image_path');
            }
            if (!Schema::hasColumn('sppgs', 'contact_phone')) {
                $table->string('contact_phone')->nullable()->after('manager_name');
            }
            if (!Schema::hasColumn('sppgs', 'address')) {
                $table->string('address')->nullable()->after('contact_phone');
            }
            if (!Schema::hasColumn('sppgs', 'operational_hours')) {
                $table->string('operational_hours')->default('06:00 - 14:00')->after('address');
            }
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
