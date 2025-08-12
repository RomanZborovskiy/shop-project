<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\ProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function show()
    {
        return view('admin.profile.index');
    }
    public function showPasswordForm()
    {
        return view('admin.profile.confirm-password');
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

        return view('admin.profile.edit');
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();

        $user->mediaManage($request);

        session()->forget('password_confirmed');

        return redirect()->route('profile.show')->with('success', 'Профіль оновлено.');
    }

}
