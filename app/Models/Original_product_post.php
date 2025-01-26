<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Original_product_post extends Model
{
    protected $fillable = ['original_product_id', 'posted_user_profile_id'];

    public function product()
    {
        return $this->belongsTo(Original_product::class, 'original_product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'posted_user_profile_id');
    }
}
