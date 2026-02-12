<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AttendanceApproval extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'petugas_id',
        'voting_booth_id',
        'status',
        'approved_at',
        'voted_at',
        'session_token',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'voted_at' => 'datetime',
        ];
    }

    /**
     * Get the mahasiswa for this attendance
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    /**
     * Get the petugas who approved this attendance
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /**
     * Get the voting booth for this attendance
     */
    public function votingBooth(): BelongsTo
    {
        return $this->belongsTo(VotingBooth::class);
    }

    /**
     * Generate unique session token for offline voting
     */
    public function generateSessionToken(): string
    {
        do {
            $token = strtoupper(Str::random(6));
        } while (self::where('session_token', $token)->exists());

        $this->update(['session_token' => $token]);

        return $token;
    }

    /**
     * Approve this attendance
     */
    public function approve(): void
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);
        $this->generateSessionToken();
    }

    /**
     * Mark as voted
     */
    public function markAsVoted(): void
    {
        $this->update([
            'status' => 'voted',
            'voted_at' => now(),
        ]);
    }

    /**
     * Check if approved and ready to vote
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if already voted
     */
    public function hasVoted(): bool
    {
        return $this->status === 'voted';
    }
}
