<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected User $author;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::factory()->create([
            'role' => UserRole::AUTHOR,
        ]);
    }

    public function test_author_can_create_book(): void
    {
        $response = $this
            ->actingAs($this->author, 'api')
            ->postJson('/api/books', [
                'title'       => 'Laravel Mastery',
                'description' => 'Complete Laravel Guide',
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('books', [
            'title' => 'Laravel Mastery',
        ]);
    }

    public function test_author_can_view_books(): void
    {
        Book::factory()->create([
            'author_id' => $this->author->id,
        ]);

        $response = $this
            ->actingAs($this->author, 'api')
            ->getJson('/api/books');

        $response->assertStatus(200);
    }

    public function test_author_can_view_single_book(): void
    {
        $book = Book::factory()->create([
            'author_id' => $this->author->id,
        ]);

        $response = $this
            ->actingAs($this->author, 'api')
            ->getJson("/api/books/{$book->id}");

        $response->assertStatus(200);
    }

    public function test_author_can_update_book(): void
    {
        $book = Book::factory()->create([
            'author_id' => $this->author->id,
        ]);

        $response = $this
            ->actingAs($this->author, 'api')
            ->putJson("/api/books/{$book->id}", [
                'title'       => 'Updated Book',
                'description' => 'Updated Description',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('books', [
            'id'    => $book->id,
            'title' => 'Updated Book',
        ]);
    }

    public function test_author_can_delete_book(): void
    {
        $book = Book::factory()->create([
            'author_id' => $this->author->id,
        ]);

        $response = $this
            ->actingAs($this->author, 'api')
            ->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200);
    }

    public function test_author_cannot_view_other_author_book(): void
    {
        $otherAuthor = User::factory()->create([
            'role' => UserRole::AUTHOR,
        ]);

        $book = Book::factory()->create([
            'author_id' => $otherAuthor->id,
        ]);

        $this->assertNotEquals(
            $this->author->id,
            $book->author_id
        );

        $response = $this
            ->actingAs($this->author, 'api')
            ->getJson("/api/books/{$book->id}");

        $response->assertForbidden(); // 403
    }
}