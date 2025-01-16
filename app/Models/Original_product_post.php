<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Original_product_post extends Model
{
    public $timestamps = false;

    protected $fillable = ['original_product_id', 'posted_user_id'];
}
