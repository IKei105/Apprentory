<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
