<?php

namespace App\Http\Auth\Api\Controllers;

use App\Http\Auth\Api\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function sendResetLink(UserRequest $request)
    {
        $request->validated();

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Посилання для скидання пароля надіслано на email.']);
        }

        return response()->json(['error' => 'Не вдалося надіслати посилання'], 422);
    }

    // Скидання пароля
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'=> 'required|email',
            'token'=> 'required|string',
            'password'=> 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Пароль успішно змінено']);
        }

        return response()->json(['error' => 'Токен недійсний або прострочений'], 422);
    }
}