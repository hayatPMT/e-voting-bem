<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'user_id',
        'kandidat_id',
        'encrypted_kandidat_id',
        'vote_hash',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who voted
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the mahasiswa who voted
     */
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaProfile::class, 'user_id', 'user_id');
    }

    /**
     * Get the kandidat who received the vote
     */
    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }

    /**
     * Get decrypted kandidat ID from encrypted vote
     * Used only for counting results, not for individual vote lookup
     */
    public function getDecryptedKandidatId(): ?int
    {
        if (! $this->encrypted_kandidat_id) {
            return $this->kandidat_id; // Fallback for old votes
        }

        try {
            return decrypt($this->encrypted_kandidat_id);
        } catch (\Exception $e) {
            return null;
        }
    }
}
