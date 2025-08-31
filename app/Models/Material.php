<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User_like;
use App\Models\Material_post;
use App\Models\Technologie;

class Material extends Model
{
    protected $fillable = [
        'title',
        'price',
        'material_detail',
        'material_url',
        'rating_id',
        'image_dir',
        'category_id',
    ];

    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }
    
    public function likes()
    {
        return $this->belongsToMany(User::class, 'user_likes', 'material_id', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Material_post::class, 'material_id');
    }

    public function posted_likes()
    {
        return $this->hasMany(User_like::class, 'material_id');
    }

    public function technologies()
    {
        return $this->belongsToMany(
            Technologie::class,
            'material_technologie_tags',
            'material_id',
            'technologie_id'
        );
    }
    
    public function postedUser()
    {
        return $this->hasManyThrough(
            User::class,
            Material_post::class,
            'material_id',
            'id',
            'id',
            'posted_user_id'
        );
    }

    public function postedUserProfile()
    {
        return $this->hasOneThrough(
            Profile::class,
            Material_post::class,
            'material_id',
            'user_id',
            'id',
            'posted_user_id'
        );
    }

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }
}
