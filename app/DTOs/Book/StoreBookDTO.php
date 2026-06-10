<?php

namespace App\DTOs\Book;

readonly class StoreBookDTO
{
    public function __construct(
        public int $authorId,
        public string $title,
        public ?string $description
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            authorId: auth()->id(),
            title: $data['title'],
            description: $data['description'] ?? null
        );
    }
}