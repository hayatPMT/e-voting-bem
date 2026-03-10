<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'kampus_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the admin profile for the user
     */
    public function adminProfile(): HasOne
    {
        return $this->hasOne(AdminProfile::class);
    }

    /**
     * Get the mahasiswa profile for the user
     */
    public function mahasiswaProfile(): HasOne
    {
        return $this->hasOne(MahasiswaProfile::class);
    }

    /**
     * Get the vote for the user
     */
    public function vote(): HasOne
    {
        return $this->hasOne(Vote::class);
    }

    /**
     * Get the campus this user belongs to
     */
    public function kampus(): BelongsTo
    {
        return $this->belongsTo(Kampus::class);
    }

    /**
     * Get attendance approvals as mahasiswa
     */
    public function attendanceApprovals(): HasMany
    {
        return $this->hasMany(AttendanceApproval::class, 'mahasiswa_id');
    }

    /**
     * Get attendance approvals made by this petugas
     */
    public function approvalsMade(): HasMany
    {
        return $this->hasMany(AttendanceApproval::class, 'petugas_id');
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has admin-level access (super_admin or admin)
     */
    public function hasAdminAccess(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    /**
     * Check if user is mahasiswa
     */
    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    /**
     * Check if user is petugas daftar hadir
     */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas_daftar_hadir';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login' => now()]);
    }

    /**
     * Get user's profile based on role
     */
    public function getProfile(): AdminProfile|MahasiswaProfile|null
    {
        return $this->hasAdminAccess() ? $this->adminProfile : $this->mahasiswaProfile;
    }
}
