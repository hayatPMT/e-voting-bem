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
        Schema::create('attendance_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('voting_booth_id')->nullable()->constrained('voting_booths')->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'voted'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('voted_at')->nullable();
            $table->string('session_token')->nullable()->unique();
            $table->timestamps();

            // Index untuk faster queries
            $table->index('status');
            $table->index('mahasiswa_id');
            $table->index('petugas_id');
            $table->index('session_token');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_approvals');
    }
};
