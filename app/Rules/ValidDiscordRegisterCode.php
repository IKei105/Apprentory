<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\TempRegisterCode;

class ValidDiscordRegisterCode implements Rule
{
    public function passes($attribute, $value)
    {
        return TempRegisterCode::where('discord_id', request()->input('discord-ID'))
            ->where('register_code', request()->input('register-code'))
            ->exists();
    }

    public function message()
    {
        return 'Discord ID または 登録コードが無効です。';
    }
}

