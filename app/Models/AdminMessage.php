<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content',
        'type',
        'target',
        'read',
    ];

    public function match()
    {
        return $this->belongsTo(Match::class, 'target');
    }

    public function userBet()
    {
        return $this->belongsTo(UserBet::class, 'target');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'target');
    }
}
