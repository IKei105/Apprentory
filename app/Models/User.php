<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function likedMaterials()
    {
        return $this->belongsToMany(Material::class, 'user_likes', 'user_id', 'material_id');
    }
}
