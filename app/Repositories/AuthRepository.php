<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

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
    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
    }
    public function changePassword(array $data)
{
    $user = auth()->user();

    if (!Hash::check($data['old_password'], $user->password)) {

        throw ValidationException::withMessages([
            'old_password' => ['Old password is incorrect.']
        ]);
    }

    $user->update([
        'password' => Hash::make($data['password'])
    ]);

    return true;
}
public function forgotPassword(array $data)
{
    $status = Password::sendResetLink([
        'email' => $data['email'],
    ]);

    if ($status !== Password::RESET_LINK_SENT) {
        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }

    return true;
}
public function resetPassword(array $data)
{
    $status = Password::reset(
        $data,
        function ($user, $password) {

            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();

        }
    );

    if ($status !== Password::PASSWORD_RESET) {

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);

    }

    return true;
}
}
            