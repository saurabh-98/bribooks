<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\ReviewLog;

use App\Enums\BookStatus;

use App\Repositories\Contracts\ReviewRepositoryInterface;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function approve(
        Book $book
    ): Book {

        $book->update([
            'status' => BookStatus::APPROVED->value,
        ]);

        return $book->fresh();
    }

    public function reject(
        Book $book
    ): Book {

        $book->update([
            'status' => BookStatus::REJECTED->value,
        ]);

        return $book->fresh();
    }

    public function createLog(
        array $data
    ): void {

        ReviewLog::create(
            $data
        );
    }
}