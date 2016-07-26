<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Team;


class Player extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'team_id',
        'role',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
