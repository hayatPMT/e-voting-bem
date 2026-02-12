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
        Schema::create('tahapan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tahapan');
            $table->text('deskripsi')->nullable();
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->enum('status', ['draft', 'active', 'completed'])->default('draft');
            $table->boolean('is_current')->default(false);
            $table->timestamps();

            // Index untuk faster queries
            $table->index('status');
            $table->index('is_current');
            $table->index(['waktu_mulai', 'waktu_selesai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahapan');
    }
};
