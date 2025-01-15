<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Original_product extends Model
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
    public function technologies()
    {
        return $this->belongsToMany(Technologie::class, 'original_product_technologie_tag');
    }

}