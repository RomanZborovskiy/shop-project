<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Requests\ProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        return response()->json([
            'success' => true,
            'user' => Auth::user(),
        ]);
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

        return response()->json([
            'success' => true,
            'message' => 'Профіль оновлено',
            'user' => $user,
        ]);
    }
}
