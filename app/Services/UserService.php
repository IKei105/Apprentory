<?php

namespace App\Services;

use App\Models\User;
use App\Models\Profile;
use App\Models\TempRegisterCode;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserService
{
    public function getTomorrowDate(): string
    {
        return Carbon::tomorrow()->toDateString();
    }

    public function createTempRegisterCode(string $discordId, string $registerCode, string $expiresAt): void
    {
        
        TempRegisterCode::create([
            'discord_id' => $discordId,
            'register_code' => bcrypt($registerCode),
            'expires_at' => $expiresAt
        ]);
    }

    //Rulesを使うのでこの関数は使用しません
    public function checkTempRegisterCode(string $discordId, string $registerCode): bool
    {
        $records = TempRegisterCode::where('discord_id', $discordId)->get();

        foreach ($records as $record) {
            if (Hash::check($registerCode, $record->register_code)) {
                return true;
            }
        }

        return false;
    }

    public function createUser(array $request): User
    {
        return User::create([
            'userid' => $request['userid'], // ✅ 配列なので `[]` でアクセス
            'term_id' => $request['term'],
            'password' => bcrypt($request['password']),
        ]);
    }

    public function createProfile(int $userid, array $validatedRequest): void
    {
        if (isset($validatedRequest['user-profile-image']) && $validatedRequest['user-profile-image'] !== null) {
            // 画像が存在する場合、profile_image に画像パスを保存
            $profileImagePath = '/storage/' . request()->file('user-profile-image')->store('user_profile_images', 'public'); // ←ここのパス変えた
        } else {
            // 画像が選ばれていない場合は、デフォルト画像を設定
            $profileImagePath = '/assets/images/user_image_default.svg'; // デフォルトの画像を設定 ←ここのパス変えた
        }
        Profile::create([
            'user_id' => $userid, // Userの主キー
            'username' => $validatedRequest['user-name'],
            'profile_image' => $profileImagePath,
            'discord_id' => $validatedRequest['discord-ID'],
        ]);
    }


}
