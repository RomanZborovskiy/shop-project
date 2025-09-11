<?php

namespace App\Http\Auth\Api\Controllers;

use App\Http\Auth\Api\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoginUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $user = User::create($request->all());
        return UserResource::make($user);
    }

    public function login(UserRequest $request)
    {
        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'message'=>'Wrong email or password'
            ], 401);
        }

        $user=Auth::user();
        $user->tokens()->delete();
        return LoginUserResource::make($user);
    }

    public function logout(Request $request) 
    {
        $user=Auth::user();

        if ($user = $request->user()) {
            $user->tokens()->delete();
            
            return response()->json(['message' => 'Logged out successfully']);
        }
    
    return response()->json(['message' => 'No authenticated user'], 401);
    }
}