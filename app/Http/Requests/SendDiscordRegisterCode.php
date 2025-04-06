<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendDiscordRegisterCode extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //'discord-id' => ['required', 'regex:/^\d{18}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'discord-id.required' => 'Discord IDを入力してください。',
            'discord-id.regex' => 'Discord IDは18桁の数字で入力してください。',
        ];
    }
}
