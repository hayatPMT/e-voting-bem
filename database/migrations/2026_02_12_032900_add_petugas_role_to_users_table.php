<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the role enum to include 'petugas_daftar_hadir'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'mahasiswa', 'petugas_daftar_hadir') NOT NULL DEFAULT 'mahasiswa'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'mahasiswa') NOT NULL DEFAULT 'mahasiswa'");
    }
};
