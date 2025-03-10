<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_follow extends Model
{
    protected $fillable = ['follower_id', 'following_id']; // ✅ これを追加
    public $timestamps = false; // timestamps を使わないなら追加

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'following_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'following_id');
    }
}
