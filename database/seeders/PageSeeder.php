<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Chapter;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::first();

        Page::create([
            'chapter_id' => $chapter->id,
            'title' => 'Page 1',
            'content' => 'Laravel Introduction Content',
            'page_no' => 1,
        ]);
    }
}