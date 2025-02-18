<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Original_product;

class Original_product_comment extends Model
{
    
    use HasFactory;

    protected $fillable = ['original_product_id', 'commented_user_id', 'comment'];

    /**
     * コメントが関連するオリジナルプロダクト
     */
    public function product()
    {
        return $this->belongsTo(Original_product::class, 'original_product_id');
    }

    /**
     * コメントを投稿したユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'commented_user_id');
    }
}
