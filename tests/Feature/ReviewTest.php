<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Enums\BookStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_reviewer_can_approve_submitted_book(): void
    {
        User::factory()->create([
            'role' => 'reviewer',
        ]);

        $book = Book::factory()->create([
            'status' => BookStatus::SUBMITTED,
        ]);

        $this->assertEquals(
            BookStatus::SUBMITTED,
            $book->status
        );

        $book->update([
            'status' => BookStatus::APPROVED,
        ]);

        $this->assertEquals(
            BookStatus::APPROVED,
            $book->fresh()->status
        );
    }

    public function test_reviewer_can_reject_submitted_book(): void
    {
        User::factory()->create([
            'role' => 'reviewer',
        ]);

        $book = Book::factory()->create([
            'status' => BookStatus::SUBMITTED,
        ]);

        $book->update([
            'status' => BookStatus::DRAFT,
        ]);

        $this->assertEquals(
            BookStatus::DRAFT,
            $book->fresh()->status
        );
    }

    public function test_reviewer_cannot_approve_draft_book(): void
    {
        User::factory()->create([
            'role' => 'reviewer',
        ]);

        $book = Book::factory()->create([
            'status' => BookStatus::DRAFT,
        ]);

        $this->assertNotEquals(
            BookStatus::SUBMITTED,
            $book->status
        );
    }
}