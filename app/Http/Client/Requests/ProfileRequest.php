<?php

namespace App\Http\Client\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
        $user = Auth::user();
        return [
           'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,'. $user->id ],
            'password' => ['nullable', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ];
    }


}
