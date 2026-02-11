<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    protected $fillable = ['nama', 'visi', 'misi', 'foto'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
