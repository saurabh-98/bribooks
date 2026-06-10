<?php

namespace App\DTOs\Book;

readonly class BookVersionDTO
{
    public function __construct(
        public int $bookId,
        public array $snapshot,
        public int $createdBy
    ) {}
}