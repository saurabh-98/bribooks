<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_api_is_reachable(): void
    {
        $response = $this->getJson('/api/auth/profile');

        $response->assertStatus(401);
    }
}