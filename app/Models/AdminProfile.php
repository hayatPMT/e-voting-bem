<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    protected $table = 'admin_profiles';

    protected $fillable = [
        'user_id',
        'phone',
        'department',
        'address',
        'city',
        'province',
        'postal_code',
        'avatar',
        'bio',
        'status',
        'appointed_at',
        'terminated_at',
    ];

    protected $casts = [
        'appointed_at' => 'datetime',
        'terminated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the admin profile
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
     * Check if admin is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
