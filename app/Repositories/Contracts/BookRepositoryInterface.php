<?php

namespace App\Repositories\Contracts;

use App\Models\Book;
use App\DTOs\Book\StoreBookDTO;
use App\DTOs\Book\UpdateBookDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BookRepositoryInterface
{
  
    public function create(
        StoreBookDTO $dto
    ): Book;

   
    public function update(
        Book $book,
        UpdateBookDTO $dto
    ): Book;

    
    public function delete(
        Book $book
    ): bool;

  
    public function findById(
        int $id
    ): ?Book;

  
    public function getAuthorBooks(
        int $authorId
    ): LengthAwarePaginator;

   
    public function updateStatus(
        Book $book,
        string $status
    ): Book;


    public function publish(
        Book $book
    ): Book;
}