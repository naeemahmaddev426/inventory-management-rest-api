<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;

class AuthController extends Controller
{
     public function __construct(
        protected AuthService $authService
    ) {

    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request);

        return response()->json([

            'success' => true,

            'message' => 'User registered successfully.',

            'data' => new UserResource($user)

        ],201);
    }
    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request);

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'token' => $data['token'],
            'user' => new UserResource($data['user']),
        ]);
    }
    public function profile(Request $request)
{
    return response()->json([
        'success' => true,
        'user' => new UserResource($request->user())
    ]);
}

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.'
        ]);
    }
    public function changePassword(ChangePasswordRequest $request)
{
    $this->authService->changePassword($request);

    return response()->json([
        'success' => true,
        'message' => 'Password changed successfully.'
    ]);
}
public function forgotPassword(ForgotPasswordRequest $request)
{
    $this->authService->forgotPassword($request);

    return response()->json([
        'success' => true,
        'message' => 'Password reset link sent successfully.',
    ]);
}
public function resetPassword(ResetPasswordRequest $request)
    {
        $this->authService->resetPassword($request);

        return response()->json([

            'success' => true,

            'message' => 'Password reset successfully.'

        ]);
    }
}
