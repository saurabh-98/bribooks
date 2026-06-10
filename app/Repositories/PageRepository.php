<?php

namespace App\Repositories;

use App\Models\Page;
use App\DTOs\Page\StorePageDTO;
use App\DTOs\Page\UpdatePageDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\PageRepositoryInterface;

class PageRepository implements PageRepositoryInterface
{
    public function create(
        StorePageDTO $dto
    ): Page {

        return Page::create([
            'chapter_id' => $dto->chapterId,
            'title'      => $dto->title,
            'content'    => $dto->content,
            'page_no'    => $dto->pageNo,
        ]);
    }

    public function update(
        Page $page,
        UpdatePageDTO $dto
    ): Page {

        $page->update([
            'title'   => $dto->title,
            'content' => $dto->content,
            'page_no' => $dto->pageNo,
        ]);

        return $page->fresh();
    }

    public function delete(
        Page $page
    ): bool {

        return $page->delete();
    }

    public function findById(
        int $id
    ): ?Page {

        return Page::with([
            'chapter.book'
        ])->find($id);
    }

    public function getUserPages(
        int $userId
    ): LengthAwarePaginator {

        return Page::with([
                'chapter.book'
            ])
            ->whereHas(
                'chapter.book',
                fn ($query) =>
                    $query->where(
                        'author_id',
                        $userId
                    )
            )
            ->latest()
            ->paginate(10);
    }
}