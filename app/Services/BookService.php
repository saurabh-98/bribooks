<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\DB;

use App\DTOs\Book\StoreBookDTO;
use App\DTOs\Book\UpdateBookDTO;

use App\Events\BookCreated;
use App\Events\BookUpdated;
use App\Events\BookDeleted;

use App\Exceptions\BookDeleteException;
use App\Exceptions\BookPublishedException;

use App\Repositories\Contracts\BookRepositoryInterface;

class BookService
{
    public function __construct(
        protected BookRepositoryInterface $bookRepository
    ) {}

    public function create(
        StoreBookDTO $dto
    ): Book {

        return DB::transaction(function () use ($dto) {

            $book = $this->bookRepository
                ->create($dto);

            event(
                new BookCreated($book)
            );

            return $book->fresh();
        });
    }

    public function update(
        Book $book,
        UpdateBookDTO $dto
    ): Book {

        if ($book->isPublished()) {
            throw new BookPublishedException();
        }

        return DB::transaction(function () use ($book, $dto) {

            $book = $this->bookRepository
                ->update(
                    $book,
                    $dto
                );

            event(
                new BookUpdated($book)
            );

            return $book->fresh();
        });
    }

    public function delete(
        Book $book
    ): bool {

        if ($book->isPublished()) {
            throw new BookDeleteException();
        }

        return DB::transaction(function () use ($book) {

            event(
                new BookDeleted($book)
            );

            return $this->bookRepository
                ->delete($book);
        });
    }

    public function findById(
        int $id
    ): ?Book {

        return $this->bookRepository
            ->findById($id);
    }

    public function getMyBooks()
    {
        return $this->bookRepository
            ->getAuthorBooks(
                auth()->id()
            );
    }
}