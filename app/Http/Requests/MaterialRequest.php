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
            'material_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'material-title' => 'required|string|max:255',
            'material-thoughts' => 'required|string',
            'material-rate' => 'required|integer|between:1,5',
            'material-price' => 'required|numeric|min:0',
            'material-url' => 'required|url',
            'select' => 'required|integer|exists:tags,id',
        ];
    }

    public function messages()
    {
        return [
            'material_image.required' => '画像をアップロードしてください。',
            'material_image.image' => 'アップロードされたファイルは画像である必要があります。',
            'material_image.mimes' => '画像はjpeg、png、jpg、またはgif形式でアップロードしてください。',
            'material_image.max' => '画像のサイズは2MB以下にしてください。',
            
            'material-title.required' => 'タイトルを入力してください。',
            'material-title.string' => 'タイトルは文字列で入力してください。',
            'material-title.max' => 'タイトルは255文字以下で入力してください。',
            
            'material-thoughts.required' => '感想を入力してください。',
            'material-thoughts.string' => '感想は文字列で入力してください。',
            
            'material-rate.required' => '評価を選択してください。',
            'material-rate.integer' => '評価は数値で入力してください。',
            'material-rate.between' => '評価は1から5の間で選択してください。',
            
            'material-price.required' => '金額を入力してください。',
            'material-price.numeric' => '金額は数値で入力してください。',
            'material-price.min' => '金額は0以上で入力してください。',
            
            'material-url.required' => 'URLを入力してください。',
            'material-url.url' => '有効なURL形式で入力してください。',
            
            'select.required' => 'タグを選択してください。',
            'select.integer' => 'タグは数値で指定してください。',
            'select.exists' => '選択されたタグが無効です。',
        ];
        
    }
}
