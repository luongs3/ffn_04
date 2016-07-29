<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function getRoleAttribute($value)
    {
        if($value == config('common.player.role.footballer')) {
            return trans('label.footballer');
        }

        return trans('label.coach');
    }
}
