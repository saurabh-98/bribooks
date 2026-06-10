<?php

namespace App\Services;

use App\Repositories\Contracts\DashboardRepositoryInterface;

class DashboardService
{
    public function __construct(
        protected DashboardRepositoryInterface $dashboardRepository
    ) {}

    public function getStats(): array
    {
        return $this->dashboardRepository
            ->getStats(
                auth()->id()
            );
    }
}