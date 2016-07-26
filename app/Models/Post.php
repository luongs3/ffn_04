<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{User, Category, League, Comment};

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'league_id',
        'slug',
        'title',
        'content',
        'excerpt',
        'published_at',
    ];

    public function league()
    {
        return $this->belongsTo(League::class, 'league_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable_id');
    }
}
