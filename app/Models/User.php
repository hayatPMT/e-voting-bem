<?php

namespace App\Models;

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
    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class);
    }

    /**
     * Get the mahasiswa profile for the user
     */
    public function mahasiswaProfile()
    {
        return $this->hasOne(MahasiswaProfile::class);
    }

    /**
     * Get the vote for the user
     */
    public function vote()
    {
        return $this->hasOne(Vote::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
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
     * Get attendance approvals as mahasiswa
     */
    public function attendanceApprovals()
    {
        return $this->hasMany(AttendanceApproval::class, 'mahasiswa_id');
    }

    /**
     * Get attendance approvals made by this petugas
     */
    public function approvalsMade()
    {
        return $this->hasMany(AttendanceApproval::class, 'petugas_id');
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin()
    {
        $this->update(['last_login' => now()]);
    }

    /**
     * Get user's profile based on role
     */
    public function getProfile()
    {
        return $this->isAdmin() ? $this->adminProfile : $this->mahasiswaProfile;
    }
}
