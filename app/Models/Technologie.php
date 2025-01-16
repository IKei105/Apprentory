<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technologie extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    // プロダクトとの多対多リレーション
    public function products()
    {
        return $this->belongsToMany(Original_product::class, 'original_product_technologie_tags');
    }
}
