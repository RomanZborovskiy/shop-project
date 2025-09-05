<?php

namespace App\Http\admin\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $productId = $this->route('product')?->id;
        
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'quantity' => 'required|integer',
            'sku' => [
                'required',
                'string',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'status'=>'required',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'seo' => 'array',
            'seo.title' => 'nullable|string|max:255',
            'seo.description' => 'nullable|string|max:500',
            'seo.keywords' => 'nullable|string|max:255',

        ];
    }
}
