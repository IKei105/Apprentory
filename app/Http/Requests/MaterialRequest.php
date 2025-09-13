<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Material_technologie_tag;

class MaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'material-image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'material-title' => 'required|max:255',
            'material-thoughts' => 'required|max:1000',
            'material-rate' => 'required|exists:ratings,id',
            'material-price' => 'nullable|integer|between:0,100000',
            'is_free' => 'nullable|in:0',
            'material-url' => 'required|max:15000',
            'select1' => 'required|integer|exists:technologies,id',
            'select2' => 'nullable|integer|exists:technologies,id',
            'select3' => 'nullable|integer|exists:technologies,id',
            'select4' => 'nullable|integer|exists:technologies,id',
            'select5' => 'nullable|integer|exists:technologies,id',
            'material-category' => 'required|integer|exists:material_categories,id',
        ];
    }

    public function messages()
    {
        return [
            'material-image.required' => '画像をアップロードしてください。',
            'material-title.required' => 'タイトルを入力してください。',
            'material-title.max' => '255文字以内で入力してください',
            'material-thoughts.required' => '感想を入力してください。',
            'material-thoughts.max' => '1000文字以内で入力してください',
            'material-rate.required' => '評価を選択してください。',
            'material-price.required' => '金額を入力してください。',
            'material-url.required' => 'URLを入力してください。',
            'select1.required' => 'タグを選択してください。',
            'select1.exists' => '選択されたタグは無効です。',
        ];
    }

}
