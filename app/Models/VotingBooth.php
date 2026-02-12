<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotingBooth extends Model
{
    protected $fillable = [
        'nama_booth',
        'lokasi',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get attendance approvals for this booth
     */
    public function attendanceApprovals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AttendanceApproval::class);
    }

    /**
     * Get active attendance approvals for this booth
     */
    public function activeApprovals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AttendanceApproval::class)
            ->where('status', 'approved');
    }
}
