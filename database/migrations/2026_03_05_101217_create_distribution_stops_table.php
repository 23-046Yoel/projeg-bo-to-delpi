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
        Schema::create('distribution_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribution_route_id')->constrained()->onDelete('cascade');
            $table->foreignId('beneficiary_id')->constrained('beneficiary_groups')->onDelete('cascade');
            $table->integer('order');
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamp('arrival_time')->nullable();
            $table->string('handover_photo')->nullable();
            $table->string('handover_doc_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution_stops');
    }
};
