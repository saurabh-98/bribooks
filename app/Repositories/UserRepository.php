<?php

namespace App\Repositories;

use App\Models\User;
use App\DTOs\Auth\RegisterDTO;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(RegisterDTO $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => bcrypt($dto->password),
            'role' => $dto->role,
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where(
            'email',
            $email
        )->first();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }
}