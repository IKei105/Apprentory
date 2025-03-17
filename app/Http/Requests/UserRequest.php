<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // ユーザーのリクエストを許可
    }

    /**
     * バリデーションルールを定義
     */
    public function rules(): array
    {
        return [
            'userid' => 'required|unique:users', // ユーザーIDが必須 & ユニーク
            'term' => 'required|exists:terms,id', // term_idが存在するかチェック
            'password' => 'required|min:8|confirmed', // 8文字以上 & 確認用と一致
            'discord-ID' => 'required|string', // Discord ID は必須の文字列
            'register-code' => 'required|string|size:16', // 16桁の文字列
        ];
    }

    /**
     * エラーメッセージのカスタマイズ
     */
    public function messages(): array
    {
        return [
            'userid.required' => 'ユーザーIDを入力してください。',
            'userid.unique' => 'このユーザーIDはすでに使用されています。',
            'term.required' => '期生を選択してください。',
            'term.exists' => '選択した期生は無効です。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
            'discord-ID.required' => 'Discord ID を入力してください。',
            'discord-ID.string' => 'Discord ID は文字列で入力してください。',
            'register-code.required' => '登録コードを入力してください。',
            'register-code.string' => '登録コードは文字列で入力してください。',
            'register-code.size' => '登録コードは16桁で入力してください。',
        ];
    }
}
