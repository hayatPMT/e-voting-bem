<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'kampus_id',
        'election_name',
        'election_logo',
        'voting_start',
        'voting_end',
    ];

    /**
     * Get the campus this setting belongs to
     */
    public function kampus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kampus::class);
    }

    protected $casts = [
        'voting_start' => 'datetime',
        'voting_end' => 'datetime',
    ];
}
