<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // using Schema builder ensures compatibility across database drivers
        if (! \Illuminate\Support\Facades\Schema::hasColumn('votes', 'is_abstain')) {
            \Illuminate\Support\Facades\Schema::table('votes', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->boolean('is_abstain')->default(false)->after('vote_hash');
            });
        }

        // make kandidat_id nullable; schema builder handles the driver-specific SQL
        if (\Illuminate\Support\Facades\Schema::hasColumn('votes', 'kandidat_id')) {
            \Illuminate\Support\Facades\Schema::table('votes', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->unsignedBigInteger('kandidat_id')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (\Illuminate\Support\Facades\Schema::hasColumn('votes', 'kandidat_id')) {
            \Illuminate\Support\Facades\Schema::table('votes', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->unsignedBigInteger('kandidat_id')->nullable(false)->change();
            });
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn('votes', 'is_abstain')) {
            \Illuminate\Support\Facades\Schema::table('votes', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->dropColumn('is_abstain');
            });
        }
    }
};
