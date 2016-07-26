<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class SocialAcount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'type',
        'social_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
