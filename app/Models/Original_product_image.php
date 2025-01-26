<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Original_product_image extends Model
{
    public $timestamps = false;

    protected $fillable = ['original_product_id', 'image_dir'];
    
    public function product()
    {
        return $this->belongsTo(Original_product::class, 'original_product_id');
    }
}
