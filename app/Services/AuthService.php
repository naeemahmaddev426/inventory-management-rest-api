<?php

namespace App\Services;

use App\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;

class AuthService
{
    public function __construct(
        protected AuthRepositoryInterface $authRepository
    ) {}

    public function register(RegisterRequest $request)
    {
        return $this->authRepository->register($request);
    }
    public function login(LoginRequest $request)
    {
        return $this->authRepository->login($request);
    }
}