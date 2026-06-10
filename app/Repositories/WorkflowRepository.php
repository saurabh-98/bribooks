<?php

namespace App\Repositories;

use App\Models\Book;
use App\Enums\BookStatus;
use App\Repositories\Contracts\WorkflowRepositoryInterface;

class WorkflowRepository implements WorkflowRepositoryInterface
{
    public function findBook(
        int $bookId
    ): Book {

        return Book::findOrFail(
            $bookId
        );
    }

    public function updateStatus(
        Book $book,
        string $status
    ): Book {

        $book->update([
            'status' => $status
        ]);

        return $book->fresh();
    }

    public function publish(
        Book $book
    ): Book {

        $book->update([
            'status' => BookStatus::PUBLISHED,
            'published_at' => now(),
        ]);

        return $book->fresh();
    }
}