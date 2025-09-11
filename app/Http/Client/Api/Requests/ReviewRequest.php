<?php

namespace App\Http\Client\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'rating'=> 'integer',
            'comment'=> 'nullable|string|max:1000',
            'parent_id'=> 'nullable|exists:reviews,id',
        ];
    }
}
