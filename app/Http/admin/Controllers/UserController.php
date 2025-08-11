<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function show()
    {
        return view('admin.users.index');
    }

    public function showPasswordForm()
    {
        return view('admin.users.confirm-password');
    }

    public function confirmPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors(['password' => 'Невірний пароль']);
        }

        session(['password_confirmed' => true]);

        return redirect()->route('profile.edit');
    }

    public function edit(Request $request)
    {
        if (!session('password_confirmed')) {
            return redirect()->route('profile.confirm.password.form');
        }

        return view('admin.users.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:2048'], 
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();

        if ($request->hasFile('avatar')) {

            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        session()->forget('password_confirmed');

        return redirect()->route('profile.show')->with('success', 'Профіль оновлено.');
    }

}
