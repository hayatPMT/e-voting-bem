<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    protected $fillable = ['kampus_id', 'nama', 'visi', 'misi', 'foto', 'total_votes'];

    public function kampus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kampus::class);
    }

    public function votes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function incrementVote()
    {
        return $this->increment('total_votes');
    }
}
