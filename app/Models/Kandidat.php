<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    protected $fillable = ['nama', 'visi', 'misi', 'foto', 'total_votes'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function incrementVote()
    {
        return $this->increment('total_votes');
    }
}
