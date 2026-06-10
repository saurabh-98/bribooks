<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Book;
use App\Services\BookService;
use App\DTOs\Book\StoreBookDTO;
use App\DTOs\Book\UpdateBookDTO;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;

class BookController extends BaseApiController
{
    public function __construct(
        protected BookService $bookService
    ) {}

    /**
     * Display books of authenticated author
     */
    public function index()
    {
        try {

            $books = $this->bookService
                ->getMyBooks();

            return $this->success(
                $books,
                'Books fetched successfully'
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Store book
     */
    public function store(
        StoreBookRequest $request
    ) {
        try {

            $book = $this->bookService->create(
                StoreBookDTO::fromArray(
                    $request->validated()
                )
            );

            return $this->success(
                $book,
                'Book created successfully',
                201
            );

        } catch (Throwable $e) {

            return $this->error(
                $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Show book
     */
    public function show(Book $book)
    {
        $this->authorize('view', $book);

        return $this->success(
            $book->load([
                'author',
                'chapters.pages',
                'versions',
                'uploads'
            ]),
            'Book fetched successfully'
        );
    }
    /**
     * Update book
     */
    public function update(
        UpdateBookRequest $request,
        Book $book
    ) {
        $this->authorize(
            'update',
            $book
        );

        try {

            $book = $this->bookService->update(
                $book,
                UpdateBookDTO::fromArray(
                    $request->validated()
                )
            );

            return $this->success(
                $book,
                'Book updated successfully'
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
     * Delete book
     */
    public function destroy(
        Book $book
    ) {
        $this->authorize(
            'delete',
            $book
        );

        try {

            $this->bookService
                ->delete($book);

            return $this->success(
                null,
                'Book deleted successfully'
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