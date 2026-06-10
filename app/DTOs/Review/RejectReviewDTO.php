<?php

namespace App\DTOs\Review;

readonly class RejectReviewDTO
{
    public function __construct(
        public int $reviewerId,
        public string $remarks
    ) {}

    public static function fromArray(
        array $data
    ): self {

        return new self(
            reviewerId: auth()->id(),
            remarks: $data['remarks']
        );
    }
}