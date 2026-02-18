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
        Schema::table('admin_profiles', function (Blueprint $table) {
            $table->dropColumn(['address', 'city', 'province', 'postal_code', 'bio', 'appointed_at', 'terminated_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_profiles', function (Blueprint $table) {
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('bio')->nullable();
            $table->timestamp('appointed_at')->nullable();
            $table->timestamp('terminated_at')->nullable();
        });
    }
};
