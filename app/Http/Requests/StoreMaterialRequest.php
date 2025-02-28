<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'material-image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'material-title' => 'required',
            'material-thoughts' => 'required',
            'material-rate' => 'required',
            'material-price' => 'required',
            'material-url' => 'required',
            'select1' => 'required|integer', //|exists:technologies,id ←これはテクノロジーテーブルにデータのセットが完了したらやります
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
