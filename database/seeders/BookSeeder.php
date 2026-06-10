<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where(
            'role',
            'author'
        )->first();

        Book::create([
            'author_id' => $author->id,
            'title' => 'Laravel Fundamentals',
            'description' => 'Laravel Learning Book',
            'status' => 'draft',
        ]);
    }
}