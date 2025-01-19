<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['userid','term_id', 'password'];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }
}
