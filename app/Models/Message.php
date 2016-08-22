<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'content',
        'type',
        'target',
        'read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
