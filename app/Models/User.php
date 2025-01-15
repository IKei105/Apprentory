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
        return $this->hasOne(Profile::class);
    }

    //user作成時に自動でprofileも生成
    protected static function booted()
    {
        static::created(function (User $user) {
            // ユーザーの作成直後に Profile を自動生成
            $user->profile()->create([
                'username' => $user->userid,     // 初期値として `userid` を使用
                'profile_image' => asset('assets/images/user_image_default.svg'), // サンプル画像など
            ]);
        });
    }    
}
