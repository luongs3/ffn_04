<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{User, Player, Rank, League, Match};

class Team extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'logo',
        'league_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_bets', 'team_id', 'role_id')->withPivot('match_id', 'point', 'result');
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function matchs()
    {
        return $this->hasMany(Match::class, 'team_id');
    }
}
