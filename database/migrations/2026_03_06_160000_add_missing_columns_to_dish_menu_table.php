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
        Schema::table('dish_menu', function (Blueprint $table) {
            if (!Schema::hasColumn('dish_menu', 'menu_id')) {
                $table->foreignId('menu_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('dish_menu', 'dish_id')) {
                $table->foreignId('dish_id')->after('menu_id')->nullable()->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('dish_menu', 'portions')) {
                $table->integer('portions')->after('dish_id')->default(1);
            }
        });
    }  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dish_menu', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropForeign(['dish_id']);
            $table->dropColumn(['menu_id', 'dish_id', 'portions']);
        });
    }
};
