<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * View book
     */
    public function view(
        User $user,
        Book $book
    ): bool {

        return
            $book->author_id === $user->id ||
            $user->isReviewer() ||
            $user->isAdmin();
    }

    /**
     * Update book
     */
    public function update(
        User $user,
        Book $book
    ): bool {

        return
            $book->author_id === $user->id &&
            ! $book->isPublished();
    }

    /**
     * Delete book
     */
    public function delete(
        User $user,
        Book $book
    ): bool {

        return
            $book->author_id === $user->id &&
            ! $book->isPublished();
    }

    /**
     * Submit book
     */
    public function submit(
        User $user,
        Book $book
    ): bool {

        return
            $user->isAuthor() &&
            $book->author_id === $user->id &&
            $book->isDraft();
    }

    /**
     * Approve book
     */
    public function approve(
        User $user,
        Book $book
    ): bool {

        return
            $user->isReviewer() &&
            $book->isSubmitted();
    }

    /**
     * Reject book
     */
    public function reject(
        User $user,
        Book $book
    ): bool {

        return
            $user->isReviewer() &&
            $book->isSubmitted();
    }

    /**
     * Publish book
     */
    public function publish(
        User $user,
        Book $book
    ): bool {

        return
            $user->isAdmin() &&
            $book->isApproved();
    }
}