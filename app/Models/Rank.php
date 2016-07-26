<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{Season, Team};

class Rank extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'season_id',
        'team_id',
        'score',
        'number',
    ];

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class, 'team_id');
    }
}
