<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\BookVersion;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VersionTest extends TestCase
{
    use RefreshDatabase;

    public function test_version_can_be_created(): void
    {
        $user = User::factory()->create([
            'role' => 'author',
        ]);

        $book = Book::factory()->create([
            'author_id' => $user->id,
        ]);

        $version = BookVersion::create([
            'book_id' => $book->id,
            'version' => 1,
            'snapshot' => json_encode([
                'title' => $book->title,
            ]),
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas(
            'book_versions',
            [
                'id' => $version->id,
                'book_id' => $book->id,
            ]
        );
    }

    public function test_book_can_have_multiple_versions(): void
    {
        $book = Book::factory()->create();

        BookVersion::factory()->create([
            'book_id' => $book->id,
            'version' => 1,
        ]);

        BookVersion::factory()->create([
            'book_id' => $book->id,
            'version' => 2,
        ]);

        $this->assertEquals(
            2,
            BookVersion::where(
                'book_id',
                $book->id
            )->count()
        );
    }

    public function test_version_belongs_to_book(): void
    {
        $book = Book::factory()->create();

        $version = BookVersion::factory()->create([
            'book_id' => $book->id,
        ]);

        $this->assertEquals(
            $book->id,
            $version->book->id
        );
    }

    public function test_snapshot_is_stored(): void
    {
        $book = Book::factory()->create();

        $snapshot = [
            'title' => $book->title,
            'description' => $book->description,
        ];

        $version = BookVersion::factory()->create([
            'book_id' => $book->id,
            'snapshot' => json_encode($snapshot),
        ]);

        $this->assertNotEmpty(
            $version->snapshot
        );
    }
}