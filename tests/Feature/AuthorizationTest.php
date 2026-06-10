<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Policies\BookPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_view_own_book(): void
    {
        $author = User::factory()->create([
            'role' => 'author',
        ]);

        $book = Book::factory()->create([
            'author_id' => $author->id,
        ]);

        $policy = app(BookPolicy::class);

        $this->assertTrue(
            $policy->view(
                $author,
                $book
            )
        );
    }

    public function test_author_cannot_view_other_author_book(): void
    {
        $author1 = User::factory()->create([
            'role' => 'author',
        ]);

        $author2 = User::factory()->create([
            'role' => 'author',
        ]);

        $book = Book::factory()->create([
            'author_id' => $author2->id,
        ]);

        $policy = app(BookPolicy::class);

        $this->assertFalse(
            $policy->view(
                $author1,
                $book
            )
        );
    }

    public function test_reviewer_can_view_any_book(): void
    {
        $reviewer = User::factory()->create([
            'role' => 'reviewer',
        ]);

        $book = Book::factory()->create();

        $policy = app(BookPolicy::class);

        $this->assertTrue(
            $policy->view(
                $reviewer,
                $book
            )
        );
    }

    public function test_admin_can_view_any_book(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $book = Book::factory()->create();

        $policy = app(BookPolicy::class);

        $this->assertTrue(
            $policy->view(
                $admin,
                $book
            )
        );
    }

    public function test_author_can_update_own_draft_book(): void
    {
        $author = User::factory()->create([
            'role' => 'author',
        ]);

        $book = Book::factory()->create([
            'author_id' => $author->id,
            'status' => 'draft',
        ]);

        $policy = app(BookPolicy::class);

        $this->assertTrue(
            $policy->update(
                $author,
                $book
            )
        );
    }

    public function test_author_cannot_update_published_book(): void
    {
        $author = User::factory()->create([
            'role' => 'author',
        ]);

        $book = Book::factory()->create([
            'author_id' => $author->id,
            'status' => 'published',
        ]);

        $policy = app(BookPolicy::class);

        $this->assertFalse(
            $policy->update(
                $author,
                $book
            )
        );
    }

    public function test_author_can_delete_own_draft_book(): void
    {
        $author = User::factory()->create([
            'role' => 'author',
        ]);

        $book = Book::factory()->create([
            'author_id' => $author->id,
            'status' => 'draft',
        ]);

        $policy = app(BookPolicy::class);

        $this->assertTrue(
            $policy->delete(
                $author,
                $book
            )
        );
    }

    public function test_author_cannot_delete_published_book(): void
    {
        $author = User::factory()->create([
            'role' => 'author',
        ]);

        $book = Book::factory()->create([
            'author_id' => $author->id,
            'status' => 'published',
        ]);

        $policy = app(BookPolicy::class);

        $this->assertFalse(
            $policy->delete(
                $author,
                $book
            )
        );
    }
}