<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Original_product_technologie_tag extends Model
{
    public $timestamps = false; // タイムスタンプを無効化

    protected $fillable = [
        'original_product_id',
        'technologie_id',
        ];

    public function technologies()
    {
        return $this->belongsToMany(Technologie::class, 'original_product_technologie_tags', 'original_product_id', 'technologie_id');
    }

}
