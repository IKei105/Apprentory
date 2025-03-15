<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    use HasFactory;

    // テーブル名（Laravelの命名規則に基づいているため省略可能）
    protected $table = 'material_categories';

    // 保存可能なカラム（category_name のみ）
    protected $fillable = ['category_name'];

    /**
     * カテゴリーに関連する教材を取得するリレーション
     */
    public function materials()
    {
        return $this->hasMany(Material::class, 'category_id');
    }
}
