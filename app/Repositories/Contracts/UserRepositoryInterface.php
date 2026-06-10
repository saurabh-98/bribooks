<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\DTOs\Auth\RegisterDTO;

interface UserRepositoryInterface
{
    public function create(RegisterDTO $dto): User;

    public function findByEmail(string $email): ?User;

    public function findById(int $id): ?User;
}