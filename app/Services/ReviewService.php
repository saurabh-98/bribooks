<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;

use App\Models\Book;

use App\DTOs\Review\ApproveReviewDTO;
use App\DTOs\Review\RejectReviewDTO;

use App\Events\BookApproved;
use App\Events\BookRejected;

use App\Repositories\Contracts\ReviewRepositoryInterface;

class ReviewService
{
    public function __construct(
        protected ReviewRepositoryInterface $reviewRepository,
        protected VersionService $versionService
    ) {}

    public function approve(
        Book $book,
        ApproveReviewDTO $dto
    ): Book {

        return DB::transaction(function () use (
            $book,
            $dto
        ) {

            if (! $book->isSubmitted()) {

                throw new Exception(
                    'Book is not under review.'
                );
            }

            $book = $this->reviewRepository
                ->approve(
                    $book
                );

            $this->reviewRepository
                ->createLog([
                    'book_id' => $book->id,
                    'reviewer_id' => $dto->reviewerId,
                    'action' => 'approved',
                    'remarks' => $dto->remarks,
                ]);

            $this->versionService
                ->createSnapshot(
                    $book
                );

            event(
                new BookApproved(
                    $book
                )
            );

            return $book;
        });
    }

    public function reject(
        Book $book,
        RejectReviewDTO $dto
    ): Book {

        return DB::transaction(function () use (
            $book,
            $dto
        ) {

            if (! $book->isSubmitted()) {

                throw new Exception(
                    'Book is not under review.'
                );
            }

            $book = $this->reviewRepository
                ->reject(
                    $book
                );

            $this->reviewRepository
                ->createLog([
                    'book_id' => $book->id,
                    'reviewer_id' => $dto->reviewerId,
                    'action' => 'rejected',
                    'remarks' => $dto->remarks,
                ]);

            $this->versionService
                ->createSnapshot(
                    $book
                );

            event(
                new BookRejected(
                    $book
                )
            );

            return $book;
        });
    }
}