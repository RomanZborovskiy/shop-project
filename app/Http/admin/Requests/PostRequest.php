<?php

namespace App\Http\admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $postId = $this->route('post')?->id;

        return [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'text' => 'required|string',
            'tags' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'seo' => 'array',
            'seo.title' => 'nullable|string|max:255',
            'seo.description' => 'nullable|string|max:500',
            'seo.keywords' => 'nullable|string|max:255',
        ];
    }
}
