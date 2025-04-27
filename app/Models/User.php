<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['userid', 'term_id', 'password'];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'following_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'following_id');
    }

    public function isFollowing($userId)
    {
        return $this->following()->where('following_id', $userId)->exists();
    }

    public function follow(User $user)
    {
        if (!$this->isFollowing($user->id)) { // すでにフォローしている場合は実行しない
            $this->following()->attach($user->id);
        }
    }

    public function unfollow(User $user)
    {
        if ($this->isFollowing($user->id)) { // フォローしていない場合は実行しない
            $this->following()->detach($user->id);
        }
    }

    public function show()
    {
        return false;
    }

    public function materials()
    {
        return $this->hasManyThrough(
            \App\Models\Material::class,   // ゴール: 取ってきたいモデル
            \App\Models\Material_post::class, // 中間テーブル
            'posted_user_id',              // 中間テーブルの、ユーザーIDカラム
            'id',                          // materials テーブルの、idカラム
            'id',                          // users テーブルの、idカラム
            'material_id'                  // 中間テーブルの、materialsへの外部キー
        );
    }

    public function products()
    {
        return $this->hasManyThrough(
            \App\Models\Original_product::class,   
            \App\Models\Original_product_post::class, 
            'posted_user_profile_id',    
            'id',              
            'id',              
            'original_product_id'   
        );
    }

    public function term()
    {
        return $this->belongsTo(\App\Models\Term::class);
    }
}
