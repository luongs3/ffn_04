<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchEvent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'match_id',
        'time',
        'icon',
        'image',
        'title',
        'content',
    ];

    public function match()
    {
        return $this->belongsTo(Match::class);
    }
}
