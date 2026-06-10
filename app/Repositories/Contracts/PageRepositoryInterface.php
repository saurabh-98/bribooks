<?php

namespace App\Repositories\Contracts;

use App\Models\Page;
use App\DTOs\Page\StorePageDTO;
use App\DTOs\Page\UpdatePageDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PageRepositoryInterface
{
    public function create(
        StorePageDTO $dto
    ): Page;

    public function update(
        Page $page,
        UpdatePageDTO $dto
    ): Page;

    public function delete(
        Page $page
    ): bool;

    public function findById(
        int $id
    ): ?Page;

    public function getUserPages(
        int $userId
    ): LengthAwarePaginator;
}