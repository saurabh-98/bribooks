<?php

namespace App\Events;

use App\Models\Chapter;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChapterDeleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Chapter $chapter
    ) {}
}