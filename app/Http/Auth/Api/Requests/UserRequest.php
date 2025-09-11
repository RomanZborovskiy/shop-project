<?php

namespace App\Http\Auth\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $routeName = $this->route()->getName();

        return match ($routeName) {
            'api.register' => [
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'phone'    => 'nullable|string|max:20',
                'password' => 'required|min:6|confirmed',
            ],

            'api.login' => [
                'email'    => 'required|email',
                'password' => 'required',
            ],

            'api.sendResetLink' => [
                'email' => 'required|email',
            ],

            'api.password.reset' => [
                'token'    => 'required',
                'email'    => 'required|email',
                'password' => 'required|min:6|confirmed',
            ],

            default => [],
        };
    }
}
