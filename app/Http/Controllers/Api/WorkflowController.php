<?php

namespace App\Http\Controllers\Api;

use Throwable;

use App\Models\Book;

use App\Services\WorkflowService;

use App\DTOs\Workflow\SubmitBookDTO;
use App\DTOs\Workflow\ApproveBookDTO;
use App\DTOs\Workflow\RejectBookDTO;
use App\DTOs\Workflow\PublishBookDTO;

class WorkflowController extends BaseApiController
{
    public function __construct(
        protected WorkflowService $workflowService
    ) {}

    public function submit(
        Book $book
    )
    {
        try {

            return $this->success(
                $this->workflowService
                    ->submit(
                        new SubmitBookDTO(
                            bookId: $book->id,
                            submittedBy: auth()->id()
                        )
                    ),
                'Book submitted successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                422
            );
        }
    }

    public function approve(
        Book $book
    )
    {
        try {

            return $this->success(
                $this->workflowService
                    ->approve(
                        new ApproveBookDTO(
                            bookId: $book->id,
                            reviewerId: auth()->id()
                        )
                    ),
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

    public function reject(
        Book $book
    )
    {
        try {

            return $this->success(
                $this->workflowService
                    ->reject(
                        new RejectBookDTO(
                            bookId: $book->id,
                            reviewerId: auth()->id()
                        )
                    ),
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

    public function publish(
        Book $book
    )
    {
        try {

            return $this->success(
                $this->workflowService
                    ->publish(
                        new PublishBookDTO(
                            bookId: $book->id,
                            adminId: auth()->id()
                        )
                    ),
                'Book published successfully'
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