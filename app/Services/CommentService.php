<?php

namespace App\Services;

use App\Models\Original_product_comment;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function createComment(array $data, int $productId)
    {
        return Original_product_comment::create([
            'original_product_id' => $productId,
            'commented_user_id' => Auth::id(),
            'comment' => $data['original-product-comment'],
        ]);
    }
}
