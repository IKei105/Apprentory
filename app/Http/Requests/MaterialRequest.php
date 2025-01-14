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
            'material-image' => 'required',
            'material-title' => 'required',
            'material-thoughts' => 'required',
            'material-rate' => 'required',
            'material-price' => 'required',
            'material-url' => 'required',
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
        ];
    }
}
