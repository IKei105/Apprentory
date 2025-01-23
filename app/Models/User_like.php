<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_like extends Model
{
    protected $fillable = [
        'material_id',
        'user_id',
    ];

    // UserLike が所属する user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // UserLike が所属する material
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
