<?php

namespace App\DTOs\Page;

readonly class StorePageDTO
{
    public function __construct(
        public int $chapterId,
        public string $title,
        public string $content,
        public int $pageNo
    ) {}

    public static function fromArray(
        array $data,
        int $chapterId
    ): self {

        return new self(
            chapterId: $chapterId,
            title: trim($data['title']),
            content: trim($data['content']),
            pageNo: (int) $data['page_no']
        );
    }
}