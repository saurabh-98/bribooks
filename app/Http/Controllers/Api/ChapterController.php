<?php

namespace App\Http\Controllers\Api;

use Throwable;

use App\Models\Book;
use App\Models\Chapter;

use App\Services\ChapterService;

use App\DTOs\Chapter\StoreChapterDTO;
use App\DTOs\Chapter\UpdateChapterDTO;

use App\Http\Requests\Chapter\StoreChapterRequest;
use App\Http\Requests\Chapter\UpdateChapterRequest;

class ChapterController extends BaseApiController
{
    public function __construct(
        protected ChapterService $chapterService
    ) {}

    /**
     * List Chapters
     */
    public function index()
    {
        try {

            return $this->success(
                $this->chapterService->getMyChapters(),
                'Chapters fetched successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Create Chapter
     */
    public function store(
        StoreChapterRequest $request,
        Book $book
    )
    {
        try {

            $chapter = $this->chapterService->create(

                new StoreChapterDTO(
                    bookId: $book->id,
                    title: trim(
                        $request->title
                    ),
                    sortOrder: (int) (
                        $request->sort_order ?? 1
                    )
                )

            );

            return $this->success(
                $chapter,
                'Chapter created successfully',
                201
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                422
            );
        }
    }

    /**
     * Show Chapter
     */
    public function show(
        Chapter $chapter
    )
    {
        try {

            return $this->success(
                $this->chapterService->show(
                    $chapter
                ),
                'Chapter fetched successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                404
            );
        }
    }

    /**
     * Update Chapter
     */
    public function update(
        UpdateChapterRequest $request,
        Chapter $chapter
    )
    {
        try {

            $chapter = $this->chapterService
                ->update(
                    $chapter,
                    UpdateChapterDTO::fromArray(
                        $request->validated()
                    )
                );

            return $this->success(
                $chapter,
                'Chapter updated successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                422
            );
        }
    }

    /**
     * Delete Chapter
     */
    public function destroy(
        Chapter $chapter
    )
    {
        try {

            $this->chapterService
                ->delete(
                    $chapter
                );

            return $this->success(
                null,
                'Chapter deleted successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                422
            );
        }
    }
}