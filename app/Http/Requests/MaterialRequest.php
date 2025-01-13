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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'article' => 'required|string',
            'rating_id' => 'required|integer|between:1,5',
            'price' => 'required|numeric|min:0',
            'url' => 'required|url',
            'tag' => 'required|integer|exists:tags,id',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '画像をアップロードしてください。',
            'title.required' => 'タイトルを入力してください。',
            'article.required' => '感想を入力してください。',
            'rating_id.required' => '評価を選択してください。',
            'price.required' => '金額を入力してください。',
            'url.required' => 'URLを入力してください。',
            'tag.required' => 'タグを選択してください。',
        ];
    }
}
