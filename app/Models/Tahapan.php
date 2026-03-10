<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahapan extends Model
{
    protected $table = 'tahapan';

    protected $fillable = [
        'kampus_id',
        'nama_tahapan',
        'deskripsi',
        'waktu_mulai',
        'waktu_selesai',
        'status',
        'is_current',
    ];

    protected function casts(): array
    {
        return [
            'waktu_mulai' => 'datetime',
            'waktu_selesai' => 'datetime',
            'is_current' => 'boolean',
        ];
    }

    /**
     * Get the campus this tahapan belongs to
     */
    public function kampus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kampus::class);
    }

    /**
     * Check if tahapan is currently active
     */
    public function isActive(): bool
    {
        $now = now();

        return $this->status === 'active'
            && $now->between($this->waktu_mulai, $this->waktu_selesai);
    }

    /**
     * Check if tahapan has started
     */
    public function hasStarted(): bool
    {
        return now()->greaterThanOrEqualTo($this->waktu_mulai);
    }

    /**
     * Check if tahapan has ended
     */
    public function hasEnded(): bool
    {
        return now()->greaterThan($this->waktu_selesai);
    }

    /**
     * Get the current active tahapan
     */
    public static function getCurrentTahapan($kampusId = null): ?self
    {
        $query = self::where('is_current', true)
            ->where('status', 'active');

        if ($kampusId) {
            $query->where('kampus_id', $kampusId);
        }

        return $query->first();
    }

    /**
     * Set this tahapan as current and deactivate others
     */
    public function setAsCurrent(): void
    {
        $query = self::where('id', '!=', $this->id);

        if ($this->kampus_id) {
            $query->where('kampus_id', $this->kampus_id);
        }

        $query->update(['is_current' => false]);
        $this->update(['is_current' => true, 'status' => 'active']);
    }
}
