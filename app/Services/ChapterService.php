<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Chapter;

use App\DTOs\Chapter\StoreChapterDTO;
use App\DTOs\Chapter\UpdateChapterDTO;

use App\Events\ChapterCreated;
use App\Events\ChapterUpdated;
use App\Events\ChapterDeleted;

use App\Repositories\Contracts\ChapterRepositoryInterface;

class ChapterService
{
    public function __construct(
        protected ChapterRepositoryInterface $chapterRepository
    ) {}

    /**
     * Get all chapters of authenticated author
     */
    public function getMyChapters()
    {
        return $this->chapterRepository
            ->getUserChapters(
                auth()->id()
            );
    }

    /**
     * Show chapter
     */
    public function show(
        Chapter $chapter
    ): Chapter {

        return $chapter->load([
            'book',
            'pages'
        ]);
    }

    /**
     * Create chapter
     */
    public function create(
        StoreChapterDTO $dto
    ): Chapter {

        return DB::transaction(function () use ($dto) {

            $chapter = $this->chapterRepository
                ->create($dto);

            event(
                new ChapterCreated($chapter)
            );

            return $chapter->fresh();
        });
    }

    /**
     * Update chapter
     */
    public function update(
        Chapter $chapter,
        UpdateChapterDTO $dto
    ): Chapter {

        return DB::transaction(function () use ($chapter, $dto) {

            $chapter = $this->chapterRepository
                ->update(
                    $chapter,
                    $dto
                );

            event(
                new ChapterUpdated($chapter)
            );

            return $chapter->fresh();
        });
    }

    /**
     * Delete chapter
     */
    public function delete(
        Chapter $chapter
    ): bool {

        return DB::transaction(function () use ($chapter) {

            event(
                new ChapterDeleted($chapter)
            );

            return $this->chapterRepository
                ->delete($chapter);
        });
    }
}