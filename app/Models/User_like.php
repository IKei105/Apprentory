<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_like extends Model
{
    protected $fillable = [
        'material_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
