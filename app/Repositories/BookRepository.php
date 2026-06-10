<?php

namespace App\Repositories;

use App\Models\Book;
use App\DTOs\Book\StoreBookDTO;
use App\DTOs\Book\UpdateBookDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    public function create(
        StoreBookDTO $dto
    ): Book {

        return Book::create([
            'author_id'  => $dto->authorId,
            'title'      => $dto->title,
            'description'=> $dto->description,
            'status'     => 'draft',
        ]);
    }

    public function update(
        Book $book,
        UpdateBookDTO $dto
    ): Book {

        $book->update([
            'title'       => $dto->title,
            'description' => $dto->description,
        ]);

        return $book->fresh();
    }

    public function delete(
        Book $book
    ): bool {

        return $book->delete();
    }

    public function findById(
        int $id
    ): ?Book {

        return Book::with([
            'author',
            'chapters.pages',
            'versions',
            'uploads'
        ])->find($id);
    }

    public function getAuthorBooks(
        int $authorId
    ): LengthAwarePaginator {

        return Book::withCount([
                'chapters',
                'versions',
                'uploads'
            ])
            ->where(
                'author_id',
                $authorId
            )
            ->latest()
            ->paginate(10);
    }

    public function updateStatus(
        Book $book,
        string $status
    ): Book {

        $book->update([
            'status' => $status
        ]);

        return $book->fresh();
    }

    public function publish(
        Book $book
    ): Book {

        $book->update([
            'status'       => 'published',
            'published_at' => now(),
        ]);

        return $book->fresh();
    }
}