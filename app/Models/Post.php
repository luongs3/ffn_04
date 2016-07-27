<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = ['published_at'];

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

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        if (!$this->exists) {
            $this->attributes['slug'] = str_slug($value);
        }
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeUnpublished($query)
    {
        $query->where('published_at', '>', Carbon::now());
    }

    public function imageLink()
    {
        return \URL::to($this->image);
    }

    public function link()
    {
        return action('NewsController@show', [$this->slug]);
    }

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
