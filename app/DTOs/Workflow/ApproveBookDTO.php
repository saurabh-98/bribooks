<?php

namespace App\DTOs\Workflow;

readonly class ApproveBookDTO
{
    public function __construct(
        public int $bookId,
        public int $reviewerId
    ) {}
}