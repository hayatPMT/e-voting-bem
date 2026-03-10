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
        // Add kampus_id to votes for efficient campus-scoped queries
        Schema::table('votes', function (Blueprint $table) {
            $table->unsignedBigInteger('kampus_id')->nullable()->after('id');
            $table->index('kampus_id');
        });

        // Add kampus_id to attendance_approvals for campus isolation
        Schema::table('attendance_approvals', function (Blueprint $table) {
            $table->unsignedBigInteger('kampus_id')->nullable()->after('id');
            $table->index('kampus_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropIndex(['kampus_id']);
            $table->dropColumn('kampus_id');
        });

        Schema::table('attendance_approvals', function (Blueprint $table) {
            $table->dropIndex(['kampus_id']);
            $table->dropColumn('kampus_id');
        });
    }
};
