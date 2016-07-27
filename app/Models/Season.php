<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Rank, Match, League;

class Season extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'current',
    ];

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'season_id');
    }

    public function matches()
    {
        return $this->belongsToMany(Match::class, 'league_matches', 'season_id', 'match_id')->withPivot('league_id');
    }

    public function leagues()
    {
        return $this->belongsToMany(League::class, 'league_matches', 'season_id', 'league_id')->withPivot('match_id');
    }
}
