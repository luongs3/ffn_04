<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'status',
        'commentable_id',
        'commentable_type',
        'content',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'commentable_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
