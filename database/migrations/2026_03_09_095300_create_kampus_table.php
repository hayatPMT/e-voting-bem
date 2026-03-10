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
        Schema::create('kampus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->string('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('logo')->nullable();
            $table->string('primary_color')->default('#667eea');
            $table->string('secondary_color')->default('#764ba2');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
        });

        // Tambahkan foreign key constraint ke table settings untuk link ke kampus
        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedBigInteger('kampus_id')->nullable()->after('id');
            $table->index('kampus_id');
        });

        // Tambahkan kampus_id ke kandidats
        Schema::table('kandidats', function (Blueprint $table) {
            $table->unsignedBigInteger('kampus_id')->nullable()->after('id');
            $table->index('kampus_id');
        });

        // Tambahkan kampus_id ke voting_booths
        Schema::table('voting_booths', function (Blueprint $table) {
            $table->unsignedBigInteger('kampus_id')->nullable()->after('id');
            $table->index('kampus_id');
        });

        // Tambahkan kampus_id ke tahapan
        Schema::table('tahapan', function (Blueprint $table) {
            $table->unsignedBigInteger('kampus_id')->nullable()->after('id');
            $table->index('kampus_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tahapan', function (Blueprint $table) {
            $table->dropIndex(['kampus_id']);
            $table->dropColumn('kampus_id');
        });

        Schema::table('voting_booths', function (Blueprint $table) {
            $table->dropIndex(['kampus_id']);
            $table->dropColumn('kampus_id');
        });

        Schema::table('kandidats', function (Blueprint $table) {
            $table->dropIndex(['kampus_id']);
            $table->dropColumn('kampus_id');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropIndex(['kampus_id']);
            $table->dropColumn('kampus_id');
        });

        Schema::dropIfExists('kampus');
    }
};
