<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Material_post extends Model
{
    protected $fillable = [
        'material_id',       // 教材ID
        'posted_user_id',    // 投稿したユーザーID
    ];

    // モデルのリレーションを定義
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'posted_user_id');
    }
    
    // material_posts テーブルとのリレーション
    
}
