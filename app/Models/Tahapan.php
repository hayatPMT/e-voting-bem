<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahapan extends Model
{
    protected $table = 'tahapan';

    protected $fillable = [
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
    public static function getCurrentTahapan(): ?self
    {
        return self::where('is_current', true)
            ->where('status', 'active')
            ->first();
    }

    /**
     * Set this tahapan as current and deactivate others
     */
    public function setAsCurrent(): void
    {
        self::where('id', '!=', $this->id)->update(['is_current' => false]);
        $this->update(['is_current' => true, 'status' => 'active']);
    }
}
