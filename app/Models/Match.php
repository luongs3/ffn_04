<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Match extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team1_id',
        'team2_id',
        'score_team1',
        'score_team2',
        'start_time',
        'end_time',
        'place',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_bets', 'match_id', 'team_id')->withPivot('team_id', 'point', 'result');
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'league_matches', 'match_id', 'season_id')->withPivot('league_id');
    }

    public function leagues()
    {
        return $this->belongsToMany(League::class, 'league_matches', 'match_id', 'league_id')->withPivot('season_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function matchEvents()
    {
        return $this->hasMany(MatchEvent::class);
    }
}
