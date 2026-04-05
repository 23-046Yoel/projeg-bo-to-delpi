<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beneficiary_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of school or group
            $table->string('location')->nullable();
            $table->integer('total_beneficiaries')->default(0);
            $table->foreignId('sppg_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beneficiary_groups');
    }
};
