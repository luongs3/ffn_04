<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeagueMatch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'league_id',
        'season_id',
        'match_id',
    ];
}
