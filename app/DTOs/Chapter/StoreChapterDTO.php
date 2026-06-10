<?php

namespace App\DTOs\Chapter;

readonly class StoreChapterDTO
{
    public function __construct(
        public int $bookId,
        public string $title,
        public int $sortOrder = 1
    ) {}

    public static function fromArray(
        array $data,
        int $bookId
    ): self {

        return new self(
            bookId: $bookId,
            title: trim($data['title']),
            sortOrder: isset($data['sort_order'])
                ? (int) $data['sort_order']
                : 1
        );
    }
}