<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Services\AuthService;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends BaseApiController
{
    public function __construct(
        protected AuthService $authService
    ) {}

   
    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register(
            RegisterDTO::fromArray(
                $request->validated()
            )
        );

        return $this->success(
            $result,
            'User registered successfully',
            201
        );
    }

   
    public function login(LoginRequest $request)
    {
        try {

            $result = $this->authService->login(
                LoginDTO::fromArray(
                    $request->validated()
                )
            );

            return $this->success(
                $result,
                'Login successful'
            );

        } catch (Exception $e) {

            return $this->error(
                $e->getMessage(),
                null,
                401
            );
        }
    }

   
    public function profile()
    {
        return $this->success(
            auth('api')->user(),
            'Profile fetched successfully'
        );
    }

  
    public function logout()
    {
        $this->authService->logout();

        return $this->success(
            null,
            'Logout successful'
        );
    }
}