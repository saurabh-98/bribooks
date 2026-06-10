<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Page;
use App\Models\Chapter;
use App\Models\BookVersion;

use Illuminate\Support\Facades\DB;

use App\DTOs\Version\CreateVersionDTO;

use App\Repositories\Contracts\VersionRepositoryInterface;

class VersionService
{
    public function __construct(
        protected VersionRepositoryInterface $versionRepository
    ) {}

    /**
     * Create Version Snapshot
     */
    public function create(
        CreateVersionDTO $dto
    ): BookVersion {

        $book = $this->versionRepository
            ->findBookWithRelations(
                $dto->bookId
            );

        $snapshot = $book->toArray();

        return $this->versionRepository
            ->create([
                'book_id' => $book->id,

                'version' => $this->versionRepository
                    ->nextVersion(
                        $book->id
                    ),

                'snapshot' => json_encode(
                    $snapshot
                ),

                'created_by' => $dto->userId,
            ]);
    }

    /**
     * Shortcut Method
     */
    public function createSnapshot(
        Book $book
    ): BookVersion {

        return $this->create(
            new CreateVersionDTO(
                bookId: $book->id,
                userId: auth()->id()
            )
        );
    }

    /**
     * Get Book Versions
     */
    public function getVersions(
        Book $book
    )
    {
        return $this->versionRepository
            ->getBookVersions(
                $book->id
            );
    }

    /**
     * Show Single Version
     */
    public function show(
        Book $book,
        BookVersion $version
    ): BookVersion {

        return $this->versionRepository
            ->findVersion(
                $book->id,
                $version->id
            );
    }

    /**
     * Rollback Version
     */
    public function rollback(
        BookVersion $version
    ): Book {

        return DB::transaction(function () use (
            $version
        ) {

            $snapshot = json_decode(
                $version->snapshot,
                true
            );

            $book = Book::findOrFail(
                $snapshot['id']
            );

            /*
            |--------------------------------------------------------------------------
            | Restore Book
            |--------------------------------------------------------------------------
            */

            $book->update([
                'title' => $snapshot['title'],
                'description' => $snapshot['description'],
                'status' => $snapshot['status'],
                'published_at' =>
                    $snapshot['published_at'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Remove Existing Chapters
            |--------------------------------------------------------------------------
            */

            Chapter::where(
                'book_id',
                $book->id
            )->delete();

            /*
            |--------------------------------------------------------------------------
            | Restore Chapters & Pages
            |--------------------------------------------------------------------------
            */

            foreach (
                $snapshot['chapters']
                as $chapterData
            ) {

                $chapter = Chapter::create([
                    'book_id' => $book->id,
                    'title'   => $chapterData['title'],
                ]);

                if (
                    isset(
                        $chapterData['pages']
                    )
                ) {

                    foreach (
                        $chapterData['pages']
                        as $pageData
                    ) {

                        Page::create([
                            'chapter_id' => $chapter->id,

                            'title' => $pageData['title'],

                            'content' =>
                                $pageData['content'],

                            'page_no' =>
                                $pageData['page_no'],
                        ]);
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Create New Snapshot After Rollback
            |--------------------------------------------------------------------------
            */

            $this->createSnapshot(
                $book
            );

            return $book->fresh([
                'chapters.pages'
            ]);
        });
    }

    /**
     * Latest Version
     */
    public function latest(
        Book $book
    ): ?BookVersion {

        return $this->versionRepository
            ->getLatestVersion(
                $book->id
            );
    }

    /**
     * Find Version By Id
     */
    public function findById(
        int $id
    ): ?BookVersion {

        return $this->versionRepository
            ->findById(
                $id
            );
    }
}