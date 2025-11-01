<?php

use App\Models\Recipe;

test('search scope finds recipe by title', function () {
    $recipe = Recipe::factory()->create(['title' => 'Delicious Pasta']);
    Recipe::factory()->create(['title' => 'Boring Salad']);

    $results = Recipe::search('pasta')->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->title)->toBe('Delicious Pasta');
});

test('search scope finds recipe by description', function () {
    $recipe = Recipe::factory()->create(['description' => 'A wonderful Italian dish']);
    Recipe::factory()->create(['description' => 'Some other recipe']);

    $results = Recipe::search('Italian')->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->id)->toBe($recipe->id);
});

test('search scope finds recipe by ingredient name', function () {
    $recipe = Recipe::factory()->create();
    $recipe->ingredients()->create([
        'name' => 'Tomatoes',
        'amount' => 2,
        'unit' => 'pieces',
        'order' => 0,
    ]);

    $otherRecipe = Recipe::factory()->create();
    $otherRecipe->ingredients()->create([
        'name' => 'Lettuce',
        'amount' => 1,
        'unit' => 'head',
        'order' => 0,
    ]);

    $results = Recipe::search('tomato')->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->id)->toBe($recipe->id);
});

test('search scope is case insensitive', function () {
    Recipe::factory()->create(['title' => 'UPPERCASE RECIPE']);

    $results = Recipe::search('uppercase')->get();

    expect($results)->toHaveCount(1);
});

test('search scope with empty string returns all', function () {
    Recipe::factory()->count(3)->create();

    $results = Recipe::search('')->get();

    expect($results)->toHaveCount(3);
});

test('by difficulty scope filters correctly', function () {
    Recipe::factory()->create(['difficulty' => 'easy']);
    Recipe::factory()->create(['difficulty' => 'medium']);
    Recipe::factory()->create(['difficulty' => 'hard']);

    $results = Recipe::byDifficulty(['easy'])->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->difficulty)->toBe('easy');
});

test('by difficulty scope accepts multiple values', function () {
    Recipe::factory()->create(['difficulty' => 'easy']);
    Recipe::factory()->create(['difficulty' => 'medium']);
    Recipe::factory()->create(['difficulty' => 'hard']);

    $results = Recipe::byDifficulty(['easy', 'hard'])->get();

    expect($results)->toHaveCount(2);
});

test('by cook time scope filters quick recipes', function () {
    Recipe::factory()->create(['cook_time' => 10]);
    Recipe::factory()->create(['cook_time' => 20]);
    Recipe::factory()->create(['cook_time' => 40]);

    $results = Recipe::byCookTime(['quick'])->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->cook_time)->toBe(10);
});

test('by cook time scope filters medium recipes', function () {
    Recipe::factory()->create(['cook_time' => 10]);
    Recipe::factory()->create(['cook_time' => 25]);
    Recipe::factory()->create(['cook_time' => 40]);

    $results = Recipe::byCookTime(['medium'])->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->cook_time)->toBe(25);
});

test('by cook time scope accepts multiple ranges', function () {
    Recipe::factory()->create(['cook_time' => 10]);
    Recipe::factory()->create(['cook_time' => 25]);
    Recipe::factory()->create(['cook_time' => 90]);

    $results = Recipe::byCookTime(['quick', 'very_long'])->get();

    expect($results)->toHaveCount(2);
});

test('by meal type scope filters correctly', function () {
    Recipe::factory()->create(['category' => 'breakfast']);
    Recipe::factory()->create(['category' => 'lunch']);
    Recipe::factory()->create(['category' => 'dinner']);

    $results = Recipe::byMealType(['breakfast'])->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->category)->toBe('breakfast');
});

test('by cuisine scope filters correctly', function () {
    Recipe::factory()->create(['cuisine_type' => 'italian']);
    Recipe::factory()->create(['cuisine_type' => 'chinese']);

    $results = Recipe::byCuisine(['italian'])->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->cuisine_type)->toBe('italian');
});

test('by dietary tags scope filters with single tag', function () {
    Recipe::factory()->create(['dietary_tags' => ['vegetarian', 'gluten-free']]);
    Recipe::factory()->create(['dietary_tags' => ['vegan']]);

    $results = Recipe::byDietaryTags(['vegetarian'])->get();

    expect($results)->toHaveCount(1);
});

test('by dietary tags scope uses and logic for multiple tags', function () {
    Recipe::factory()->create(['dietary_tags' => ['vegetarian', 'gluten-free']]);
    Recipe::factory()->create(['dietary_tags' => ['vegetarian']]);
    Recipe::factory()->create(['dietary_tags' => ['gluten-free']]);

    // Should only return recipe with BOTH tags
    $results = Recipe::byDietaryTags(['vegetarian', 'gluten-free'])->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->dietary_tags)->toBe(['vegetarian', 'gluten-free']);
});
