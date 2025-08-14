<?php

namespace App\Http\admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'status' => 'required|string',
            'type' => 'nullable|string',
            'user_info' => 'nullable|array',
            'purchases' => 'required|array',
            'purchases.*.product_id' => 'required|exists:products,id',
            'purchases.*.quantity' => 'required|integer|min:1',
            'purchases.*.price' => 'required|numeric|min:0',
        ];
    }
}
