<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\TempRegisterCode;
use Illuminate\Support\Facades\Hash;

class ValidDiscordRegisterCode implements Rule
{
    public function passes($attribute, $value)
    {

        $tempRegisterCodes = TempRegisterCode::where('discord_id', request()->input('discord-ID'))->get();

        foreach ($tempRegisterCodes as $tempRegisterCode) {
            if (Hash::check($value, $tempRegisterCode->register_code)) {
                return true;
            }
        }

        return false;
    }

    public function message()
    {
        return 'Discord ID または 登録コードが無効です。';
    }
}

