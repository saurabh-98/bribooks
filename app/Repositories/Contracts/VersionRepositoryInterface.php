<?php

namespace App\Repositories\Contracts;

use App\Models\Book;
use App\Models\BookVersion;
use Illuminate\Support\Collection;

interface VersionRepositoryInterface
{
    public function findBookWithRelations(
        int $bookId
    ): Book;

    public function create(
        array $data
    ): BookVersion;

    public function nextVersion(
        int $bookId
    ): int;

    public function findById(
        int $id
    ): ?BookVersion;

    public function getBookVersions(
        int $bookId
    ): Collection;

    public function getLatestVersion(
        int $bookId
    ): ?BookVersion;

    public function findVersion(
        int $bookId,
        int $versionId
    ): BookVersion;
}