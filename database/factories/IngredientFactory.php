<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ingredients = [
            'flour', 'sugar', 'salt', 'pepper', 'butter', 'eggs', 'milk', 'water',
            'chicken', 'beef', 'pork', 'fish', 'rice', 'pasta', 'tomatoes', 'onions',
            'garlic', 'olive oil', 'cheese', 'cream', 'potatoes', 'carrots', 'celery',
            'basil', 'oregano', 'thyme', 'parsley', 'lemon', 'lime', 'vinegar'
        ];

        $units = ['g', 'kg', 'ml', 'l', 'cup', 'cups', 'tbsp', 'tsp', 'piece', 'pieces', 'pinch', 'clove', 'cloves'];

        return [
            'recipe_id' => Recipe::factory(),
            'name' => fake()->randomElement($ingredients),
            'amount' => fake()->randomFloat(2, 1, 500),
            'unit' => fake()->randomElement($units),
            'order' => 0,
        ];
    }
}
