<?php

namespace App\Services;

use App\Models\User;
use App\Models\Profile;
use App\Models\TempRegisterCode;
use App\Models\Material;
use App\Models\Original_product;
use Illuminate\Support\Collection;
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
            'userid' => $request['userid'],
            'term_id' => $request['term'],
            'password' => bcrypt($request['password']),
        ]);
    }

    public function createProfile(int $userid, array $validatedRequest): void
    {
        if (isset($validatedRequest['user-profile-image']) && $validatedRequest['user-profile-image'] !== null) {
            $profileImagePath = '/storage/' . request()->file('user-profile-image')->store('user_profile_images', 'public');
        } else {
            $profileImagePath = '/assets/images/user_image_default.svg';
        }
        Profile::create([
            'user_id' => $userid,
            'username' => $validatedRequest['user-name'],
            'profile_image' => $profileImagePath,
            'discord_id' => $validatedRequest['discord-ID'],
        ]);
    }

    public function getUserMaterials(User $user): Collection
    {
        return Material::whereHas('posts', function ($query) use ($user) {
            $query->where('posted_user_id', $user->id);
        })->with('postedUserProfile')->latest()->get();
    }

    public function getUserProducts(User $user): Collection
    {
        return Original_product::whereHas('posts', function ($query) use ($user) {
            $query->where('posted_user_profile_id', $user->id);
        })->with('profile')->latest()->get();
    }


}
