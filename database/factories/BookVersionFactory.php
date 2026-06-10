<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use App\Models\BookVersion;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookVersionFactory extends Factory
{
    protected $model = BookVersion::class;

    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'version' => fake()->numberBetween(1, 10),
            'snapshot' => [
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
            ],
            'created_by' => User::factory(),
        ];
    }
}