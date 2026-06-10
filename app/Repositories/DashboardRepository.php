<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\Page;
use App\Models\Upload;
use App\Models\Chapter;
use App\Enums\BookStatus;
use App\Repositories\Contracts\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getStats(
        int $userId
    ): array {

        return [

            'books' => [

                'total' => Book::where(
                    'author_id',
                    $userId
                )->count(),

                'draft' => Book::where(
                    'author_id',
                    $userId
                )
                ->where(
                    'status',
                    BookStatus::DRAFT
                )
                ->count(),

                'submitted' => Book::where(
                    'author_id',
                    $userId
                )
                ->where(
                    'status',
                    BookStatus::SUBMITTED
                )
                ->count(),

                'approved' => Book::where(
                    'author_id',
                    $userId
                )
                ->where(
                    'status',
                    BookStatus::APPROVED
                )
                ->count(),

                'published' => Book::where(
                    'author_id',
                    $userId
                )
                ->where(
                    'status',
                    BookStatus::PUBLISHED
                )
                ->count(),
            ],

            'chapters' => Chapter::whereHas(
                'book',
                fn ($query) => $query->where(
                    'author_id',
                    $userId
                )
            )->count(),

            'pages' => Page::whereHas(
                'chapter.book',
                fn ($query) => $query->where(
                    'author_id',
                    $userId
                )
            )->count(),

            'uploads' => Upload::whereHas(
                'book',
                fn ($query) => $query->where(
                    'author_id',
                    $userId
                )
            )->count(),
        ];
    }
}