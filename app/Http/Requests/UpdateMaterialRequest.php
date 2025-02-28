<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
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
            'material-image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'material-title' => 'required',
            'material-thoughts' => 'required',
            'material-rate' => 'required|integer',
            'material-price' => 'required|numeric|min:0',
            'material-url' => 'required|url',
            'select1' => 'required|integer',
        ];
    }

}
