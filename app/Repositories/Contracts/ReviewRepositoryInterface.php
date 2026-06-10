<?php

namespace App\Repositories\Contracts;

use App\Models\Book;

interface ReviewRepositoryInterface
{
    public function approve(
        Book $book
    ): Book;

    public function reject(
        Book $book
    ): Book;

    public function createLog(
        array $data
    ): void;
}