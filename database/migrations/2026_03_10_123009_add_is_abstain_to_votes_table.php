<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add is_abstain column (raw SQL for compatibility)
        DB::statement('ALTER TABLE votes ADD COLUMN IF NOT EXISTS `is_abstain` TINYINT(1) NOT NULL DEFAULT 0 AFTER `vote_hash`');

        // Make kandidat_id nullable for abstain votes
        DB::statement('ALTER TABLE votes MODIFY `kandidat_id` BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE votes MODIFY `kandidat_id` BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE votes DROP COLUMN IF EXISTS `is_abstain`');
    }
};
