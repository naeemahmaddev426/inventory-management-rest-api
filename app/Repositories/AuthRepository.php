<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\Auth\LoginRequest;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(RegisterRequest $request)
    {
        return User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

        ]);
    }
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return null;
        }

        return [
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user
        ];
    }
}
            