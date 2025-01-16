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

    //ここでテクノロジータグと結合する
    public function technologies()
    {
        return $this->belongsToMany( //多対多ねこれ
            Technologie::class, // 関連先モデル
            'material_technologie_tags', // 中間テーブル名
            'material_id', // このモデルの外部キー
            'technologie_id' // 関連先モデルの外部キー
        );
    }
    
}
