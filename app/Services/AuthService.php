<?php

namespace app\Services;

use app\Interfaces\AuthRepositoryInterface;
use app\Http\Requests\Auth\RegisterRequest;
use app\Http\Requests\Auth\LoginRequest;

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