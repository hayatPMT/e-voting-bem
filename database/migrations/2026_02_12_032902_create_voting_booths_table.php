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
        Schema::create('voting_booths', function (Blueprint $table) {
            $table->id();
            $table->string('nama_booth');
            $table->string('lokasi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index untuk faster queries
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting_booths');
    }
};
