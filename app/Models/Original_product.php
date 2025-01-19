<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Original_product extends Model
{
    use HasFactory;

    protected $table = 'original_products';

    protected $fillable = [
        'element',
        'title',
        'subtitle',
        'product_detail',
        'product_url',
        'github_url',
    ];
    // images() メソッドを追加
    public function images()
    {
        return $this->hasMany(Original_product_image::class, 'original_product_id'); // 'original_product_id' は画像テーブルの外部キー
    }
    // 必要に応じてリレーションシップを定義
    // 技術タグとの多対多リレーション
    public function technologies()
    {
        return $this->belongsToMany(
            Technologie::class,                     // 関連先モデル
            'original_product_technologie_tags',    // 中間テーブル名
            'original_product_id',                  // このモデルの外部キー
            'technologie_id'                        // 関連先モデルの外部キー
        );
    }
    public function profile()
    {
        return $this->hasOneThrough(
            Profile::class,              // 最終的に関連付けたいモデル
            Original_product_post::class, // 中間テーブルのモデル
            'original_product_id',        // 中間テーブルの外部キー
            'id',                         // Profileモデルの外部キー
            'id',                         // Original_productモデルのローカルキー
            'posted_user_profile_id'      // 中間テーブルのローカルキー
        );
    }
}