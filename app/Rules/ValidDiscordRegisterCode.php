<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\TempRegisterCode;
use Illuminate\Support\Facades\Hash;

class ValidDiscordRegisterCode implements Rule
{
    public function passes($attribute, $value)
    {

        // discord_idに基づいてすべてのレコードを取得
        $tempRegisterCodes = TempRegisterCode::where('discord_id', request()->input('discord-ID'))->get();

        // 取得したすべてのコードに対してチェック
        foreach ($tempRegisterCodes as $tempRegisterCode) {
            // ハッシュ化されたコードと入力されたコードを比較
            if (Hash::check($value, $tempRegisterCode->register_code)) {
                return true; // 一致したらtrueを返す
            }
        }

        return false; // 一致しなければfalseを返す
    }

    public function message()
    {
        return 'Discord ID または 登録コードが無効です。';
    }
}

