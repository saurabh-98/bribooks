<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Repositories\Contracts\UserRepositoryInterface;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function register(RegisterDTO $dto): array
    {
        return DB::transaction(function () use ($dto) {

            $user = $this->userRepository
                ->create($dto);

            $token = JWTAuth::fromUser($user);

            return [
                'user' => $user,
                'token' => $token,
            ];
        });
    }

    public function login(LoginDTO $dto): array
    {
        $credentials = [
            'email' => $dto->email,
            'password' => $dto->password,
        ];

        if (!$token = auth('api')->attempt($credentials)) {
            throw new Exception('Invalid credentials');
        }

        return [
            'token' => $token,
            'user' => auth('api')->user(),
        ];
    }

    public function logout(): void
    {
        auth('api')->logout();
    }
}