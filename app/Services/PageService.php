<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Page;
use App\DTOs\Page\StorePageDTO;
use App\DTOs\Page\UpdatePageDTO;
use App\DTOs\Version\CreateVersionDTO;
use App\Repositories\Contracts\PageRepositoryInterface;

class PageService
{
    public function __construct(
        protected PageRepositoryInterface $pageRepository,
        protected VersionService $versionService
    ) {}

    /**
     * Get all pages of authenticated author
     */
    public function getMyPages()
    {
        return $this->pageRepository
            ->getUserPages(
                auth()->id()
            );
    }

    /**
     * Show page
     */
    public function show(
        Page $page
    ): Page {

        return $page->load([
            'chapter.book'
        ]);
    }

    /**
     * Create page
     */
    public function create(
        StorePageDTO $dto
    ): Page {

        return DB::transaction(function () use ($dto) {

            $page = $this->pageRepository
                ->create($dto);

            $this->versionService->create(
                new CreateVersionDTO(
                    bookId: $page->chapter->book_id,
                    userId: auth()->id()
                )
            );

            return $page->fresh();
        });
    }

    /**
     * Update page
     */
    public function update(
        Page $page,
        UpdatePageDTO $dto
    ): Page {

        return DB::transaction(function () use ($page, $dto) {

            $page = $this->pageRepository
                ->update(
                    $page,
                    $dto
                );

            $this->versionService->create(
                new CreateVersionDTO(
                    bookId: $page->chapter->book_id,
                    userId: auth()->id()
                )
            );

            return $page->fresh();
        });
    }

    /**
     * Delete page
     */
    public function delete(
        Page $page
    ): bool {

        return DB::transaction(function () use ($page) {

            $bookId = $page->chapter->book_id;

            $deleted = $this->pageRepository
                ->delete($page);

            $this->versionService->create(
                new CreateVersionDTO(
                    bookId: $bookId,
                    userId: auth()->id()
                )
            );

            return $deleted;
        });
    }
}