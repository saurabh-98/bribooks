<?php

namespace App\DTOs\Workflow;

readonly class RejectBookDTO
{
    public function __construct(
        public int $bookId,
        public int $reviewerId,
        public string $reason
    ) {}
}