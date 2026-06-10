<?php

namespace App\DTOs\Chapter;

readonly class UpdateChapterDTO
{
    public function __construct(
        public string $title,
        public ?int $sortOrder = null
    ) {}

    public static function fromArray(
        array $data
    ): self {

        return new self(
            title: trim($data['title']),
            sortOrder: isset($data['sort_order'])
                ? (int) $data['sort_order']
                : null
        );
    }
}