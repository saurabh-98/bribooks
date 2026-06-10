<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Enums\BookStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_submit_draft_book(): void
    {
        $author = User::factory()->create([
            'role' => 'author',
        ]);

        $book = Book::factory()->create([
            'author_id' => $author->id,
            'status' => BookStatus::DRAFT,
        ]);

        $this->assertEquals(
            BookStatus::DRAFT,
            $book->status
        );

        $book->update([
            'status' => BookStatus::SUBMITTED,
        ]);

        $this->assertEquals(
            BookStatus::SUBMITTED,
            $book->fresh()->status
        );
    }

    public function test_reviewer_can_approve_submitted_book(): void
    {
        User::factory()->create([
            'role' => 'reviewer',
        ]);

        $book = Book::factory()->create([
            'status' => BookStatus::SUBMITTED,
        ]);

        $book->update([
            'status' => BookStatus::APPROVED,
        ]);

        $this->assertEquals(
            BookStatus::APPROVED,
            $book->fresh()->status
        );
    }

    public function test_admin_can_publish_approved_book(): void
    {
        User::factory()->create([
            'role' => 'admin',
        ]);

        $book = Book::factory()->create([
            'status' => BookStatus::APPROVED,
        ]);

        $book->update([
            'status' => BookStatus::PUBLISHED,
        ]);

        $this->assertEquals(
            BookStatus::PUBLISHED,
            $book->fresh()->status
        );
    }

    public function test_draft_book_cannot_be_published_directly(): void
    {
        $book = Book::factory()->create([
            'status' => BookStatus::DRAFT,
        ]);

        $this->assertNotEquals(
            BookStatus::APPROVED,
            $book->status
        );

        $this->assertNotEquals(
            BookStatus::PUBLISHED,
            $book->status
        );
    }
}