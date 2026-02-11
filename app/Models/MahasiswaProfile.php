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
        'address',
        'city',
        'province',
        'postal_code',
        'avatar',
        'status',
        'has_voted',
        'voted_at',
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
     * Get the full address
     */
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->province} {$this->postal_code}";
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
            return "Sudah Memilih pada {$this->voted_at->format('d-m-Y H:i')}";
        }

        return 'Belum Memilih';
    }
}
