<?php

namespace App\Interfaces;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;

interface AuthRepositoryInterface
{
    public function register(RegisterRequest $request);
    public function login(LoginRequest $request);
}