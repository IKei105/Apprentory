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
        if (!$this->isFollowing($user->id)) {
            $this->following()->attach($user->id);
        }
    }

    public function unfollow(User $user)
    {
        if ($this->isFollowing($user->id)) {
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
            \App\Models\Material::class,
            \App\Models\Material_post::class,
            'posted_user_id',
            'id',
            'id',
            'material_id'
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
