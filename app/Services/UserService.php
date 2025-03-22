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

        dd($records);
        foreach ($records as $record) {
            if (Hash::check($registerCode, $record->register_code)) {
                return true;
            }
        }

        return false;
    }

    public function createUser(array $request): User
    {
        //dd($request);
        return User::create([
            'userid' => $request['userid'], // ✅ 配列なので `[]` でアクセス
            'term_id' => $request['term'],
            'password' => bcrypt($request['password']),
        ]);
    }

    public function createProfile(int $userid, array $request, string $profileImage): void
    {
        Profile::create([
            'user_id' => $userid, // Userの主キー
            'username' => $request['userid'],
            'profile_image' => $profileImage,
            'discord_id' => $request['discord-ID'],
        ]);
    }


}
