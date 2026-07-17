<?php

namespace app\Http\Controllers\Api\V1;

use app\Http\Controllers\Controller;
use app\Http\Requests\Auth\RegisterRequest;
use app\Http\Resources\UserResource;
use app\Services\AuthService;
use app\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use app\Http\Requests\Auth\ChangePasswordRequest;
use app\Http\Requests\Auth\ForgotPasswordRequest;
use app\Http\Requests\Auth\ResetPasswordRequest;

class AuthController extends Controller
{
     public function __construct(
        protected AuthService $authService
    ) {

    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request);
        $user->sendEmailVerificationNotification();
        $token = $user->createToken('auth_token')->plainTextToken;

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
