<?php

namespace App\DTOs\Workflow;

readonly class PublishBookDTO
{
    public function __construct(
        public int $bookId,
        public int $adminId
    ) {}
}