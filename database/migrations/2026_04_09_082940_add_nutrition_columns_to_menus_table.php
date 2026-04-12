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
        Schema::table('menus', function (Blueprint $table) {
            $table->string('karbo')->nullable()->after('content');
            $table->string('protein_hewani')->nullable()->after('karbo');
            $table->string('protein_nabati')->nullable()->after('protein_hewani');
            $table->string('sayur')->nullable()->after('protein_nabati');
            $table->string('buah')->nullable()->after('sayur');
            $table->string('pelengkap')->nullable()->after('buah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['karbo', 'protein_hewani', 'protein_nabati', 'sayur', 'buah', 'pelengkap']);
        });
    }
};
