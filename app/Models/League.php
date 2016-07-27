<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Post, Season, Team, Match;

class League extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'description',
    ];

    public function matches()
    {
        return $this->belongsToMany(Match::class, 'league_matches', 'league_id', 'match_id')->withPivot('season_id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'league_matches', 'league_id', 'season_id')->withPivot('match_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'league_id');
    }
}
