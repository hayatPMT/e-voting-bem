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
        'avatar',
        'status',
    ];

    protected $casts = [];

    /**
     * Get the user that owns the admin profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    /**
     * Check if admin is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
