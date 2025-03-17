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
            'register_code' => $registerCode,
            'expires_at' => $expiresAt
        ]);
    }

    public function checkTempRegisterCode(string $discordId, string $registerCode): bool
    {
        return TempRegisterCode::where('discord_id', $discordId)
                    ->where('register_code', $registerCode)
                    ->exists();
    }

    public function createUser($request): User
    {
        return User::create([
            'userid' => $request->userid,
            'term_id' => $request->term,
            'password' => bcrypt($request->password),
        ]);
    }

    public function createProfile($userid, $request): void
    {
        Profile::create([
            'user_id' => $userid, // Userの主キーを取得して関連付け
            'username' => $request->userid,
            'profile_image' => $request->profile_image,
            'discord_id' => $request->input('discord-ID'),
        ]);
    }


}
