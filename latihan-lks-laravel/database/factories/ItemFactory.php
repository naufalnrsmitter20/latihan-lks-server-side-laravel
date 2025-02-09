<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->word(),
            "slug" => Str::slug(fake()->word()),
            "item_number" => fake()->randomNumber(1, false),
            "desc" => fake()->text(),
            "status" => "not_verified",
            "author_id" => User::factory()
        ];
    }

    public function verify(): static
    {
        return $this->state(fn (array $attributes) => [
            "status" => "verified"
        ]);
    }
}