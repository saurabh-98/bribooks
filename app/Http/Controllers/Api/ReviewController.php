<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Book;

use App\Services\ReviewService;

use App\DTOs\Review\ApproveReviewDTO;
use App\DTOs\Review\RejectReviewDTO;

use App\Http\Requests\Review\ApproveReviewRequest;
use App\Http\Requests\Review\RejectReviewRequest;

class ReviewController extends BaseApiController
{
    public function __construct(
        protected ReviewService $reviewService
    ) {}

    /**
     * Approve Book
     */
    public function approve(
        ApproveReviewRequest $request,
        Book $book
    ) {

        try {

            $book = $this->reviewService
                ->approve(
                    $book,
                    ApproveReviewDTO::fromArray(
                        $request->validated()
                    )
                );

            return $this->success(
                $book,
                'Book approved successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                422
            );
        }
    }

    /**
     * Reject Book
     */
    public function reject(
        RejectReviewRequest $request,
        Book $book
    ) {

        try {

            $book = $this->reviewService
                ->reject(
                    $book,
                    RejectReviewDTO::fromArray(
                        $request->validated()
                    )
                );

            return $this->success(
                $book,
                'Book rejected successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                422
            );
        }
    }
}