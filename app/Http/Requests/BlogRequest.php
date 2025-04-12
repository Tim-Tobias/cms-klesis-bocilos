<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'blog_category_id' => ['required'],
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'image' => $this->isMethod('post') ? ['required', 'image', 'max:4028'] : ['nullable', 'image', 'max:4028'],
            'active' => ['required', 'boolean']
        ];
    }
}
