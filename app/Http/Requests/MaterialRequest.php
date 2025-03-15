<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'material-image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'material-title' => 'required',
            'material-thoughts' => 'required',
            'material-rate' => 'required',
            'material-price' => 'nullable|integer|between:0,100000',
            'is_free' => 'nullable|in:0',
            'material-url' => 'required',
            'select1' => 'required|integer|between:1,10', // 1〜10 のみ許可
            'select2' => 'nullable|integer|between:1,10', // null または 1〜10 の整数のみ
            'select3' => 'nullable|integer|between:1,10',
            'select4' => 'nullable|integer|between:1,10',
            'material-category' => 'required|integer|in:1,2,3', // 1,2,3 のみ許可
        ];
    }

    public function messages()
    {
        return [
            'material-image.required' => '画像をアップロードしてください。',
            'material-title.required' => 'タイトルを入力してください。',
            'material-thoughts.required' => '感想を入力してください。',
            'material-rate.required' => '評価を選択してください。',
            'material-price.required' => '金額を入力してください。',
            'material-url.required' => 'URLを入力してください。',
            'select1.required' => 'タグを選択してください。',
            'select1.exists' => '選択されたタグは無効です。',
        ];
    }

}
