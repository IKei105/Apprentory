<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User_like;
use App\Models\Material_post;

class Material extends Model
{
    protected $fillable = [
        'title',
        'price',
        'material_detail',
        'material_url',
        'rating_id',
        'image_dir'
    ];

    // モデルのリレーションを定義
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

    // user_likes テーブルとのリレーション
    public function posted_likes()
    {
        return $this->hasMany(User_like::class, 'material_id');
    }
}
