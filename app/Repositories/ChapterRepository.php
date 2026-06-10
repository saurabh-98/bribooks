<?php

namespace App\Repositories;

use App\Models\Chapter;
use App\DTOs\Chapter\StoreChapterDTO;
use App\DTOs\Chapter\UpdateChapterDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\ChapterRepositoryInterface;

class ChapterRepository implements ChapterRepositoryInterface
{
    public function create(
        StoreChapterDTO $dto
    ): Chapter {

        return Chapter::create([
            'book_id'    => $dto->bookId,
            'title'      => $dto->title,
            'sort_order' => $dto->sortOrder,
        ]);
    }

    public function update(
        Chapter $chapter,
        UpdateChapterDTO $dto
    ): Chapter {

        $chapter->update([
            'title'      => $dto->title,
            'sort_order' => $dto->sortOrder,
        ]);

        return $chapter->fresh();
    }

    public function delete(
        Chapter $chapter
    ): bool {

        return $chapter->delete();
    }

    public function findById(
        int $id
    ): ?Chapter {

        return Chapter::with([
            'book',
            'pages'
        ])->find($id);
    }

    public function getUserChapters(
        int $userId
    ): LengthAwarePaginator {

        return Chapter::with([
                'book'
            ])
            ->whereHas(
                'book',
                function ($query) use ($userId) {
                    $query->where(
                        'author_id',
                        $userId
                    );
                }
            )
            ->latest()
            ->paginate(10);
    }
}