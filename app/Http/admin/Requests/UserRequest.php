<?php

namespace App\Http\admin\Requests;

use App\Models\User;
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
        $user = $this->route('user')?->id;

        $userId = $user instanceof User? $user->id: $user;

        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $userId,
            'phone'    => 'nullable|string|max:50',
            'status'   => 'nullable|string|max:50',
            'password' => 'nullable|string|min:6|confirmed',
            'avatar'   => 'nullable|image|max:2048',
            'role'     => 'required|exists:roles,name',
        ];
    }
}
