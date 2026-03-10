<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the role enum to include 'super_admin'
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'mahasiswa', 'petugas_daftar_hadir') NOT NULL DEFAULT 'mahasiswa'");
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('kampus_id')->nullable()->after('role');
            $table->index('kampus_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['kampus_id']);
            $table->dropColumn('kampus_id');
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'mahasiswa', 'petugas_daftar_hadir') NOT NULL DEFAULT 'mahasiswa'");
        }
    }
};
