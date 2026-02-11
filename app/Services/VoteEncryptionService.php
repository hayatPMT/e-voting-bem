<?php

namespace App\Services;

class VoteEncryptionService
{
    /**
     * Generate a secure hash for vote verification
     * This hash cannot be reversed to identify who voted for whom
     */
    public function generateVoteHash(int $userId, int $kandidatId): string
    {
        $salt = config('app.key');
        $timestamp = now()->timestamp;

        // Create hash with user_id, kandidat_id, timestamp, and app key as salt
        return hash('sha256', $userId.'|'.$kandidatId.'|'.$timestamp.'|'.$salt);
    }

    /**
     * Encrypt kandidat_id for storage
     * This allows us to count votes while hiding individual choices
     */
    public function encryptKandidatId(int $kandidatId): string
    {
        return encrypt($kandidatId);
    }

    /**
     * Decrypt kandidat_id for vote counting
     * Only used during result calculation, not for individual vote lookup
     */
    public function decryptKandidatId(string $encryptedKandidatId): int
    {
        return decrypt($encryptedKandidatId);
    }

    /**
     * Verify that a vote hash is valid
     */
    public function verifyVoteHash(int $userId, int $kandidatId, string $hash, int $timestamp): bool
    {
        $salt = config('app.key');
        $expectedHash = hash('sha256', $userId.'|'.$kandidatId.'|'.$timestamp.'|'.$salt);

        return hash_equals($expectedHash, $hash);
    }
}
