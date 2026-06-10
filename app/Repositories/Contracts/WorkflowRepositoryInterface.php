<?php

namespace App\Repositories\Contracts;

use App\Models\Book;

interface WorkflowRepositoryInterface
{
    public function findBook(
        int $bookId
    ): Book;

    public function updateStatus(
        Book $book,
        string $status
    ): Book;

    public function publish(
        Book $book
    ): Book;
}