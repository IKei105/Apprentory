<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Original_product;

class Original_product_comment extends Model
{
    
    use HasFactory;

    protected $fillable = ['original_product_id', 'commented_user_id', 'comment'];

    public function product()
    {
        return $this->belongsTo(Original_product::class, 'original_product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'commented_user_id');
    }
}
