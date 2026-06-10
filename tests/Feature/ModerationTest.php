<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\ModerationService;

class ModerationTest extends TestCase
{
    public function test_book_with_restricted_word_fails(): void
    {
        $service = app(
            ModerationService::class
        );

        $result = $service->moderate(
            'This book contains bomb'
        );

        $this->assertFalse(
            $result['passed']
        );

        $this->assertNotEmpty(
            $result['violations']
        );
    }

    public function test_book_with_profanity_fails(): void
    {
        $service = app(
            ModerationService::class
        );

        $result = $service->moderate(
            'You are an idiot'
        );

        $this->assertFalse(
            $result['passed']
        );
    }

    public function test_clean_content_passes(): void
    {
        $service = app(
            ModerationService::class
        );

        $result = $service->moderate(
            'Laravel is a modern PHP framework.'
        );

        $this->assertTrue(
            $result['passed']
        );

        $this->assertEmpty(
            $result['violations']
        );
    }
}