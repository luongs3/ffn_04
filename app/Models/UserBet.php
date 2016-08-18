<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'team_id',
        'match_id',
        'point',
        'result',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
