<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'material_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'material-title' => 'required|string|max:255',
            'material-thoughts' => 'required|string',
            'material-rate' => 'required|in:1,2,3,4,5',
            'material-price' => 'nullable|integer|between:0,100000',
            'material-url' => 'required|url|max:255',

            'select1' => 'required|integer|exists:technologies,id',
            'select2' => 'nullable|integer|exists:technologies,id',
            'select3' => 'nullable|integer|exists:technologies,id',
            'select4' => 'nullable|integer|exists:technologies,id',
            'select5' => 'nullable|integer|exists:technologies,id',
        ];
    }

    public function messages(): array
    {
        return [
            'material_image.image' => '画像ファイルを選択してください。',
            'material_image.mimes' => '画像の形式は jpeg, png, jpg, gif のいずれかにしてください。',
            'material_image.max' => '画像サイズは最大2MBまでです。',

            'material-title.required' => 'タイトルを入力してください。',
            'material-thoughts.required' => '感想を入力してください。',
            'material-rate.required' => '評価を選択してください。',
            'material-rate.in' => '評価は1〜5の間で選んでください。',
            'material-price.integer' => '価格は整数で入力してください。',
            'material-price.between' => '価格は0〜100000の間で入力してください。',
            'material-url.required' => 'URLを入力してください。',
            'material-url.url' => '有効なURL形式で入力してください。',

            'select1.required' => 'タグを1つ以上選択してください。',
            'select1.exists' => '選択されたタグは存在しません。',
            'select2.exists' => '選択されたタグは存在しません。',
            'select3.exists' => '選択されたタグは存在しません。',
            'select4.exists' => '選択されたタグは存在しません。',
            'select5.exists' => '選択されたタグは存在しません。',
        ];
    }
}
