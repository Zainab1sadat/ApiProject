<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return[
            'title' => 'required|max:20',
            'sub_title' => 'required|max:50',
            'price' => 'required',
            'description' => 'required',
            'image'=>'required|image|mimes:jpg,png,jpeg,bmp'
        ];
    }
}
