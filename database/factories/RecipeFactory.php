<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dietaryOptions = ['vegetarian', 'vegan', 'gluten-free', 'dairy-free', 'nut-free', 'low-carb', 'keto', 'paleo'];
        $cuisineTypes = ['Italian', 'Chinese', 'Mexican', 'Indian', 'Thai', 'French', 'Japanese', 'Greek', 'Spanish', 'American'];
        $categories = ['Breakfast', 'Lunch', 'Dinner', 'Dessert', 'Snack', 'Appetizer', 'Soup', 'Salad', 'Side Dish'];

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(3),
            'photo_path' => fake()->boolean(30) ? fake()->imageUrl(640, 480, 'food') : null,
            'cook_time' => fake()->numberBetween(10, 180),
            'difficulty' => fake()->randomElement(['easy', 'medium', 'hard']),
            'servings' => fake()->numberBetween(1, 8),
            'cuisine_type' => fake()->randomElement($cuisineTypes),
            'category' => fake()->randomElement($categories),
            'dietary_tags' => fake()->boolean(50) ? fake()->randomElements($dietaryOptions, fake()->numberBetween(1, 3)) : null,
            'status' => fake()->randomElement(['private', 'pending', 'approved', 'rejected']),
            'rejection_reason' => null,
        ];
    }

    /**
     * Indicate that the recipe is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'private',
            'rejection_reason' => null,
        ]);
    }

    /**
     * Indicate that the recipe is pending approval.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'rejection_reason' => null,
        ]);
    }

    /**
     * Indicate that the recipe is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'rejection_reason' => null,
        ]);
    }

    /**
     * Indicate that the recipe is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'rejection_reason' => fake()->sentence(),
        ]);
    }
}
