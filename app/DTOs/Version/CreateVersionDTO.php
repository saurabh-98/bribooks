<?php

namespace App\DTOs\Version;

readonly class CreateVersionDTO
{
    public function __construct(
        public int $bookId,
        public int $userId
    ) {}

    public static function fromArray(
        array $data
    ): self {
        return new self(
            bookId: $data['book_id'],
            userId: $data['user_id']
        );
    }
}