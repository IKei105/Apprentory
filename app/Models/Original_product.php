<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OriginalProduct extends Model
{
    public $timestamps = false;
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

    // 必要に応じてリレーションシップを定義
}