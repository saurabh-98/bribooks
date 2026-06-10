<?php

namespace App\Repositories\Contracts;

use App\Models\Chapter;
use App\DTOs\Chapter\StoreChapterDTO;
use App\DTOs\Chapter\UpdateChapterDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ChapterRepositoryInterface
{
    public function create(
        StoreChapterDTO $dto
    ): Chapter;

    public function update(
        Chapter $chapter,
        UpdateChapterDTO $dto
    ): Chapter;

    public function delete(
        Chapter $chapter
    ): bool;

    public function findById(
        int $id
    ): ?Chapter;

    public function getUserChapters(
        int $userId
    ): LengthAwarePaginator;
}