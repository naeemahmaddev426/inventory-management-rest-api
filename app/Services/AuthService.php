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
    public function logout($request)
    {
        return $this->authRepository->logout($request);
    }
    public function changePassword($request)
    {
        return $this->authRepository->changePassword(
            $request->validated()
        );
    }
    public function forgotPassword($request)
    {
        return $this->authRepository->forgotPassword(
            $request->validated()
        );
    }
    public function resetPassword($request)
    {
        return $this->authRepository->resetPassword(
            $request->validated()
        );
    }
}