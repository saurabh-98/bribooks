<?php

namespace App\DTOs\Workflow;

readonly class SubmitBookDTO
{
    public function __construct(
        public int $bookId,
        public int $submittedBy
    ) {}
}