<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    use HasFactory;

    protected $table = 'material_categories';

    protected $fillable = ['category_name'];

    public function materials()
    {
        return $this->hasMany(Material::class, 'category_id');
    }
}
