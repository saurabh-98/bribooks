<?php

namespace App\DTOs\Book;

readonly class UpdateBookDTO
{
    public function __construct(
        public string $title,
        public ?string $description
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null
        );
    }
}