<?php

namespace Database\Factories;

use App\Models\Like;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    protected $model = Like::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'likeable_id' => Recipe::factory(),
            'likeable_type' => Recipe::class,
            'is_like' => fake()->boolean(70), // 70% likes, 30% dislikes
        ];
    }

    /**
     * Indicate that this is a like.
     */
    public function like(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_like' => true,
        ]);
    }

    /**
     * Indicate that this is a dislike.
     */
    public function dislike(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_like' => false,
        ]);
    }
}
