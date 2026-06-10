<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        User::factory()->create([
            'name'     => 'Author User',
            'email'    => 'author@test.com',
            'password' => bcrypt('password'),
            'role'     => 'author',
        ]);

        $response = $this->postJson(
            '/api/auth/login',
            [
                'email'    => 'author@test.com',
                'password' => 'password',
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'token',
                    'user',
                ],
            ]);
    }

    public function test_invalid_login_fails(): void
    {
        $response = $this->postJson(
            '/api/auth/login',
            [
                'email'    => 'wrong@test.com',
                'password' => 'wrong',
            ]
        );

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_view_profile(): void
    {
        $user = User::factory()->create([
            'role' => 'author',
        ]);

        $token = auth('api')->login($user);

        $response = $this
            ->withHeader(
                'Authorization',
                'Bearer ' . $token
            )
            ->getJson(
                '/api/auth/profile'
            );

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }
}