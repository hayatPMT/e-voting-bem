<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EncryptExistingVotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'votes:encrypt-existing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypt existing votes in the database for enhanced security';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting encryption of existing votes...');

        $votes = \App\Models\Vote::whereNull('encrypted_kandidat_id')->get();

        if ($votes->isEmpty()) {
            $this->info('No votes to encrypt. All votes are already encrypted.');

            return Command::SUCCESS;
        }

        $encryptionService = new \App\Services\VoteEncryptionService;
        $progressBar = $this->output->createProgressBar($votes->count());
        $progressBar->start();

        foreach ($votes as $vote) {
            $vote->update([
                'encrypted_kandidat_id' => $encryptionService->encryptKandidatId($vote->kandidat_id),
                'vote_hash' => $encryptionService->generateVoteHash($vote->user_id, $vote->kandidat_id),
            ]);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);
        $this->info("Successfully encrypted {$votes->count()} votes.");

        return Command::SUCCESS;
    }
}
