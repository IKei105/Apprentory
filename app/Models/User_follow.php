<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_follow extends Model
{
    protected $fillable = ['follower_id', 'following_id'];
    public $timestamps = false;

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'following_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'following_id');
    }
}
