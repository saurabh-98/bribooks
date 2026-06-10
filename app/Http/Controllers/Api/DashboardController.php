<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Services\DashboardService;

class DashboardController extends BaseApiController
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        try {

            return $this->success(
                $this->dashboardService
                    ->getStats(),
                'Dashboard fetched successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                500
            );
        }
    }
}