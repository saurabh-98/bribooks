<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Chapter;
use Illuminate\Database\Seeder;

class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        $book = Book::first();

        Chapter::create([
            'book_id' => $book->id,
            'title' => 'Introduction',
        
        ]);
    }
}