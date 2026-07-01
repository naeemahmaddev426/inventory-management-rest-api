<?php

namespace App\Interfaces;

use App\Http\Requests\Auth\RegisterRequest;

interface AuthRepositoryInterface
{
    public function register(RegisterRequest $request);
}