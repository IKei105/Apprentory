<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['username', 'profile_image', 'user_id'];

    protected $table = 'profiles';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
