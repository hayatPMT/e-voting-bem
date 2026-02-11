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
        Schema::table('votes', function (Blueprint $table) {
            // Add encrypted kandidat_id column
            $table->text('encrypted_kandidat_id')->nullable()->after('kandidat_id');

            // Add vote hash for integrity verification
            $table->string('vote_hash', 64)->nullable()->after('encrypted_kandidat_id');

            // Add index for faster hash lookups
            $table->index('vote_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropIndex(['vote_hash']);
            $table->dropColumn(['encrypted_kandidat_id', 'vote_hash']);
        });
    }
};
