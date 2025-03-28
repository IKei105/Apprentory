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
    
    public function postedUser()
    {
        return $this->hasManyThrough(
            User::class,        // 結合先のモデル
            Material_post::class, // 中間テーブルのモデル
            'material_id',      // 中間テーブルの外部キー
            'id',               // ユーザーテーブルの主キー
            'id',               // 紐づけ元テーブルの主キー (materials)
            'posted_user_id'    // 中間テーブルのユーザーID
        );
    }

    public function postedUserProfile()
    {
        return $this->hasOneThrough(
            Profile::class,        // 取得したい最終的なモデル (Profile)
            Material_post::class,  // 中間テーブル (Material_post)
            'material_id',         // 中間テーブルの外部キー (materials への)
            'user_id',             // profile の外部キー (users への)
            'id',                  // materials の主キー
            'posted_user_id'       // 中間テーブル (Material_post) の user_id
        );
    }

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }
}
