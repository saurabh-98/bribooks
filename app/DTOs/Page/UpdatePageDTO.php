<?php

namespace App\DTOs\Page;

readonly class UpdatePageDTO
{
    public function __construct(
        public string $title,
        public string $content,
        public int $pageNo
    ) {}

    public static function fromArray(
        array $data
    ): self {

        return new self(
            title: trim($data['title']),
            content: $data['content'],
            pageNo: (int) $data['page_no']
        );
    }
}