<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Kampus extends Model
{
    protected $table = 'kampus';

    protected $fillable = [
        'nama',
        'kode',
        'slug',
        'alamat',
        'kota',
        'logo',
        'primary_color',
        'secondary_color',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot method to auto-generate slug from kode
     */
    protected static function booted(): void
    {
        static::creating(function (Kampus $kampus): void {
            if (empty($kampus->slug)) {
                $kampus->slug = static::generateSlug($kampus->kode);
            }
        });

        static::updating(function (Kampus $kampus): void {
            if ($kampus->isDirty('kode') && ! $kampus->isDirty('slug')) {
                $kampus->slug = static::generateSlug($kampus->kode);
            }
        });
    }

    /**
     * Generate a unique slug from kode
     */
    public static function generateSlug(string $kode): string
    {
        $slug = Str::slug(strtolower($kode));
        $original = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $original.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Find campus by slug
     */
    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }

    /**
     * Get the portal URL for this campus
     */
    public function getPortalUrlAttribute(): string
    {
        return url('/'.$this->slug);
    }

    /**
     * Get the admin login URL for this campus
     */
    public function getAdminLoginUrlAttribute(): string
    {
        return url('/'.$this->slug.'/login');
    }

    /**
     * Get admins that belong to this campus
     */
    public function admins(): HasMany
    {
        return $this->hasMany(User::class)->where('role', 'admin');
    }

    /**
     * Get all users that belong to this campus
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get kandidats for this campus
     */
    public function kandidats(): HasMany
    {
        return $this->hasMany(Kandidat::class);
    }

    /**
     * Get settings for this campus
     */
    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    /**
     * Get voting booths for this campus
     */
    public function votingBooths(): HasMany
    {
        return $this->hasMany(VotingBooth::class);
    }

    /**
     * Get tahapan for this campus
     */
    public function tahapan(): HasMany
    {
        return $this->hasMany(Tahapan::class);
    }

    /**
     * Get the first/active setting for this campus
     */
    public function activeSetting(): ?Setting
    {
        return $this->settings()->first();
    }

    /**
     * Get total votes cast on this campus
     */
    public function totalVotes(): int
    {
        $kampusKandidatIds = $this->kandidats()->pluck('id');

        return Vote::whereIn('kandidat_id', $kampusKandidatIds)->count()
            + $this->kandidats()->sum('total_votes');
    }

    /**
     * Check if campus is active
     */
    public function isActive(): bool
    {
        return $this->is_active === true;
    }
}
