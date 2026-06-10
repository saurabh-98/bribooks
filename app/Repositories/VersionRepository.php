<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\BookVersion;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\VersionRepositoryInterface;

class VersionRepository implements VersionRepositoryInterface
{
    public function findBookWithRelations(
        int $bookId
    ): Book {

        return Book::with([
            'chapters.pages'
        ])->findOrFail($bookId);
    }

    public function create(
        array $data
    ): BookVersion {

        return BookVersion::create($data);
    }

    public function nextVersion(
        int $bookId
    ): int {

        return (
            BookVersion::where(
                'book_id',
                $bookId
            )->max('version') ?? 0
        ) + 1;
    }

    public function findById(
        int $id
    ): ?BookVersion {

        return BookVersion::find($id);
    }

    public function getBookVersions(
        int $bookId
    ): Collection {

        return BookVersion::where(
            'book_id',
            $bookId
        )
        ->latest()
        ->get();
    }

    public function getLatestVersion(
        int $bookId
    ): ?BookVersion {

        return BookVersion::where(
            'book_id',
            $bookId
        )
        ->latest('version')
        ->first();
    }

    public function findVersion(
        int $bookId,
        int $versionId
    ): BookVersion {

        return BookVersion::where(
            'book_id',
            $bookId
        )->findOrFail(
            $versionId
        );
    }
}