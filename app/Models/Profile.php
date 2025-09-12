<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{

    use HasFactory;

    protected $fillable = ['username', 'profile_image', 'user_id', 'discord_id'];

    protected $table = 'profiles';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
