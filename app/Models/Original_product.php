<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Original_product extends Model
{
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

    public function images()
    {
        return $this->hasMany(Original_product_image::class, 'original_product_id'); // 'original_product_id' は画像テーブルの外部キー
    }

    public function technologies()
    {
        return $this->belongsToMany(
            Technologie::class,
            'original_product_technologie_tags',
            'original_product_id',
            'technologie_id'
        );
    }
    public function profile()
    {
        return $this->hasOneThrough(
            Profile::class,
            Original_product_post::class,
            'original_product_id',
            'id',
            'id',
            'posted_user_profile_id'
        );
    }

    public function postedUser()
    {
        return $this->hasOneThrough(
            User::class,
            Original_product_post::class,
            'original_product_id',
            'id',
            'id',
            'posted_user_profile_id'
        );
    }

    public function posts()
    {
        return $this->hasMany(Original_product_post::class, 'original_product_id', 'id');
    }

    
    public function getTechnologyNames()
    {
        return $this->technologies->pluck('name')->all();
    }

    public function comments()
    {
        return $this->hasMany(Original_product_comment::class, 'original_product_id');
    }

}
