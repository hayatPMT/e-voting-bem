<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MahasiswaProfile extends Model
{
    protected $table = 'mahasiswa_profiles';

    protected $fillable = [
        'user_id',
        'nim',
        'program_studi',
        'angkatan',
        'semester',
        'phone',
        'avatar',
        'status',
        'has_voted',
        'voted_at',
        'vote_receipt',
    ];

    protected $casts = [
        'has_voted' => 'boolean',
        'voted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the mahasiswa profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    /**
     * Check if mahasiswa is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Mark as voted
     */
    public function markAsVoted()
    {
        $this->update([
            'has_voted' => true,
            'voted_at' => now(),
        ]);
    }

    /**
     * Get voting status
     */
    public function getVotingStatusAttribute(): ?string
    {
        if ($this->has_voted) {
            return 'Sudah Memilih';
        }

        return 'Belum Memilih';
    }
}
