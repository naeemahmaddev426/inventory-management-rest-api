<?php

namespace app\Interfaces;

use app\Http\Requests\Auth\RegisterRequest;
use app\Http\Requests\Auth\LoginRequest;

interface AuthRepositoryInterface
{
    public function register(RegisterRequest $request);
    public function login(LoginRequest $request);
    public function logout($request);
    public function changePassword(array $data);
    public function forgotPassword(array $data);
    public function resetPassword(array $data);
}