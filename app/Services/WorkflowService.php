<?php

namespace App\Services;

use Exception;
use App\Models\Book;
use App\Enums\BookStatus;

use Illuminate\Support\Facades\DB;

use App\DTOs\Workflow\SubmitBookDTO;
use App\DTOs\Workflow\ApproveBookDTO;
use App\DTOs\Workflow\RejectBookDTO;
use App\DTOs\Workflow\PublishBookDTO;

use App\Events\BookSubmitted;
use App\Events\BookApproved;
use App\Events\BookRejected;
use App\Events\BookPublished;
use App\Events\ModerationPassed;

use App\Repositories\Contracts\WorkflowRepositoryInterface;

class WorkflowService
{
    public function __construct(
        protected WorkflowRepositoryInterface $workflowRepository,
        protected ModerationService $moderationService,
        protected VersionService $versionService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Submit Book
    |--------------------------------------------------------------------------
    */

    public function submit(
        SubmitBookDTO $dto
    ): Book {

        return DB::transaction(function () use ($dto) {

            $book = $this->workflowRepository
                ->findBook(
                    $dto->bookId
                )
                ->load([
                    'chapters.pages'
                ]);

            if (! $book->isDraft()) {

                throw new Exception(
                    'Only draft books can be submitted.'
                );
            }

            $content = $this->buildBookContent(
                $book
            );

            $violations = $this->moderationService
                ->getViolations(
                    $content
                );

            if (! empty($violations)) {

                throw new Exception(
                    'Content moderation failed. Restricted words found: '
                    . implode(', ', $violations)
                );
            }

            event(
                new ModerationPassed(
                    $book
                )
            );

            $book = $this->workflowRepository
                ->updateStatus(
                    $book,
                    BookStatus::SUBMITTED->value
                );

            $this->versionService
                ->createSnapshot(
                    $book
                );

            event(
                new BookSubmitted(
                    $book
                )
            );

            return $book->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Approve Book
    |--------------------------------------------------------------------------
    */

    public function approve(
        ApproveBookDTO $dto
    ): Book {

        return DB::transaction(function () use ($dto) {

            $book = $this->workflowRepository
                ->findBook(
                    $dto->bookId
                );

            if (! $book->isSubmitted()) {

                throw new Exception(
                    'Only submitted books can be approved.'
                );
            }

            $book = $this->workflowRepository
                ->updateStatus(
                    $book,
                    BookStatus::APPROVED->value
                );

            $this->versionService
                ->createSnapshot(
                    $book
                );

            event(
                new BookApproved(
                    $book
                )
            );

            return $book->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Reject Book
    |--------------------------------------------------------------------------
    */

    public function reject(
        RejectBookDTO $dto
    ): Book {

        return DB::transaction(function () use ($dto) {

            $book = $this->workflowRepository
                ->findBook(
                    $dto->bookId
                );

            if (! $book->isSubmitted()) {

                throw new Exception(
                    'Only submitted books can be rejected.'
                );
            }

            $book = $this->workflowRepository
                ->updateStatus(
                    $book,
                    BookStatus::REJECTED->value
                );

            $this->versionService
                ->createSnapshot(
                    $book
                );

            event(
                new BookRejected(
                    $book
                )
            );

            return $book->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Publish Book
    |--------------------------------------------------------------------------
    */

    public function publish(
        PublishBookDTO $dto
    ): Book {

        return DB::transaction(function () use ($dto) {

            $book = $this->workflowRepository
                ->findBook(
                    $dto->bookId
                );

            if (! $book->isApproved()) {

                throw new Exception(
                    'Only approved books can be published.'
                );
            }

            $book = $this->workflowRepository
                ->publish(
                    $book
                );

            $this->versionService
                ->createSnapshot(
                    $book
                );

            event(
                new BookPublished(
                    $book
                )
            );

            return $book->fresh();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    protected function buildBookContent(
        Book $book
    ): string {

        $content =
            $book->title . ' ' .
            ($book->description ?? '');

        foreach ($book->chapters as $chapter) {

            $content .= ' ' . $chapter->title;

            foreach ($chapter->pages as $page) {

                $content .= ' ' . $page->title;
                $content .= ' ' . $page->content;
            }
        }

        return $content;
    }
}