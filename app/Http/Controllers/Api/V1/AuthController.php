<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;

class AuthController extends Controller
{
     public function __construct(
        protected AuthService $authService
    ) {}

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request);

        return response()->json([

            'success' => true,

            'message' => 'User registered successfully.',

            'data' => new UserResource($user)

        ],201);
    }
}
