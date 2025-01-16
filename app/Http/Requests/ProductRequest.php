<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'product_detail' => 'required',
            'product_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'element' => 'required|in:need-tester,need-review',
            'tag_select1' => 'required|integer|exists:technologies,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルを入力してください。',
            'subtitle.required' => '概要を入力してください。',
            'product_detail.required' => '詳細を入力してください。',
            'product_url.url' => '正しいURLを入力してください。',
            'github_url.url' => '正しいGithub URLを入力してください。',
            'images.*.image' => '画像ファイルをアップロードしてください。',
            'images.*.mimes' => 'jpeg, png, jpg, gif形式の画像を選択してください。',
            'images.*.max' => '画像は2MB以下にしてください。',
            'element.required' => 'カテゴリを選択してください。',
            'element.in' => '有効なカテゴリを選択してください。',
            'tag_select.required' => 'タグを選択してください。',
            'tag_select.exists' => '選択されたタグは無効です。',
        ];
    }
}
