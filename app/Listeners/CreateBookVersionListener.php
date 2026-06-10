<?php

namespace App\Listeners;

use App\Services\VersionService;
use App\DTOs\Version\CreateVersionDTO;

class CreateBookVersionListener
{
    public function __construct(
        protected VersionService $versionService
    ) {}

    public function handle(
        object $event
    ): void {

        $bookId = null;
        $userId = null;

        if (property_exists($event, 'book')) {

            $bookId = $event->book->id;
            $userId = $event->book->author_id;
        }

        if (property_exists($event, 'chapter')) {

            $bookId = $event->chapter->book_id;
            $userId = $event->chapter
                ->book
                ->author_id;
        }

        if (property_exists($event, 'page')) {

            $bookId = $event->page
                ->chapter
                ->book_id;

            $userId = $event->page
                ->chapter
                ->book
                ->author_id;
        }

        if (!$bookId) {
            return;
        }

        $this->versionService->create(
            new CreateVersionDTO(
                bookId: $bookId,
                userId: $userId
            )
        );
    }
}