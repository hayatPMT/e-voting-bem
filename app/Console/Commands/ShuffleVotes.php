<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShuffleVotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:shuffle-votes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shuffle vote timestamps and metadata to prevent forensic timeline reconstruction';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting vote shuffling process for anonymity...');

        $votes = \App\Models\Vote::all();

        if ($votes->isEmpty()) {
            $this->warn('No votes found to shuffle.');

            return;
        }

        $bar = $this->output->createProgressBar($votes->count());
        $bar->start();

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            foreach ($votes as $vote) {
                // Randomize timestamp within a 2-hour window around the original vote
                // or just within the same day for maximum smearing.
                $originalTime = $vote->created_at;
                $randomOffset = rand(-3600, 3600); // +/- 1 hour
                $newTime = $originalTime->copy()->addSeconds($randomOffset);

                $vote->update([
                    'created_at' => $newTime,
                    'updated_at' => $newTime,
                    // Re-scramble the hash
                    'vote_hash' => hash('sha256', \Illuminate\Support\Str::random(40)),
                ]);

                $bar->advance();
            }

            \Illuminate\Support\Facades\DB::commit();
            $bar->finish();
            $this->newLine();
            $this->info('Successfully shuffled '.$votes->count().' votes.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            $this->error('Error shuffling votes: '.$e->getMessage());
        }
    }
}
