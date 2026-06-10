<?php

namespace App\Repositories\Contracts;

interface DashboardRepositoryInterface
{
    public function getStats(
        int $userId
    ): array;
}