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
        Schema::table('kandidats', function (Blueprint $table) {
            $table->unsignedInteger('total_votes')->default(0)->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kandidats', function (Blueprint $table) {
            $table->dropColumn('total_votes');
        });
    }
};
