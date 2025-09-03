<?php

namespace App\Http\admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariableRequest extends FormRequest
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
        $id = $this->route('variable')?->id;

        return [
            'key'   => 'required|unique:variables,key,' . $id,
            'value' => 'nullable|string',
        ];
    }
}
