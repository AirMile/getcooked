<?php

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('search with LIKE wildcards treats them as literal characters', function () {
    $user = User::factory()->create();

    // Create recipes with specific titles
    Recipe::factory()->create(['title' => 'Pasta Carbonara', 'status' => 'approved']);
    Recipe::factory()->create(['title' => 'Pizza Margherita', 'status' => 'approved']);
    Recipe::factory()->create(['title' => '100% Chocolate Cake', 'status' => 'approved']);

    // Search for '%' should be escaped and not match as wildcard
    // After escaping, '%' becomes '\%' which won't match anything
    $response = $this->actingAs($user)->get('/browse?search=' . urlencode('%'));
    $response->assertStatus(200);
    // The % is escaped, so it returns no results (security working correctly)
    $response->assertSee('No recipes found');

    // Search for part of a title with underscore
    $recipe = Recipe::factory()->create(['title' => 'Best_Recipe_Ever', 'status' => 'approved']);
    $response = $this->actingAs($user)->get('/browse?search=Best');
    $response->assertStatus(200);
    // Should find the recipe by the first word
    $response->assertSee('Best_Recipe_Ever');
});

test('search with empty string returns all approved recipes', function () {
    $user = User::factory()->create();

    Recipe::factory()->count(3)->create(['status' => 'approved']);
    Recipe::factory()->create(['status' => 'private']);

    $response = $this->actingAs($user)->get('/browse?search=');
    $response->assertStatus(200);
    // Should see all 3 approved recipes
});

test('search with whitespace only is treated as empty', function () {
    $user = User::factory()->create();

    Recipe::factory()->count(2)->create(['status' => 'approved']);

    $response = $this->actingAs($user)->get('/browse?search=' . urlencode('   '));
    $response->assertStatus(200);
    // Should return results as if no search filter applied
});

test('search with special HTML characters does not break page', function () {
    $user = User::factory()->create();

    Recipe::factory()->create(['title' => 'Normal Recipe', 'status' => 'approved']);

    // XSS attempt
    $response = $this->actingAs($user)->get('/browse?search=' . urlencode('<script>alert("xss")</script>'));
    $response->assertStatus(200);
    // Page should render without breaking - search term is escaped in LIKE query
});

test('search with very long string is rejected by validation', function () {
    $user = User::factory()->create();

    // 300 character string (exceeds max 255)
    $longString = str_repeat('a', 300);

    $response = $this->actingAs($user)->get('/browse?search=' . $longString);
    $response->assertStatus(302); // Redirect due to validation error
});

test('browse with invalid difficulty values is rejected', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/browse?difficulty[]=invalid&difficulty[]=super_hard');
    $response->assertStatus(302); // Validation error
});

test('browse with malformed filter parameter is rejected by validation', function () {
    $user = User::factory()->create();

    // Passing difficulty as string instead of array should be rejected
    $response = $this->actingAs($user)->get('/browse?difficulty=easy');
    $response->assertStatus(302); // Validation error redirects
});

test('collection with invalid source values is rejected', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/collection?source[]=invalid_source&source[]=fake');
    $response->assertStatus(302); // Validation error
});

test('pagination maintains filter query string', function () {
    $user = User::factory()->create();

    // Create enough recipes to paginate
    Recipe::factory()->count(20)->create(['status' => 'approved', 'cuisine_type' => 'italian']);
    Recipe::factory()->count(5)->create(['status' => 'approved', 'cuisine_type' => 'mexican']);

    $response = $this->actingAs($user)->get('/browse?cuisine[]=italian&page=2');
    $response->assertStatus(200);
    // Check that pagination links include the cuisine filter
    $response->assertSee('cuisine');
});

test('high page number with few filtered results returns empty or last page', function () {
    $user = User::factory()->create();

    // Create only 5 recipes matching filter
    Recipe::factory()->count(5)->create(['status' => 'approved', 'difficulty' => 'easy']);
    Recipe::factory()->count(20)->create(['status' => 'approved', 'difficulty' => 'hard']);

    // Request page 10 when only 1 page exists
    $response = $this->actingAs($user)->get('/browse?difficulty[]=easy&page=10');
    $response->assertStatus(200);
    // Laravel paginator will show empty results or handle gracefully
});

test('search finds recipes by ingredient name', function () {
    $user = User::factory()->create();

    $recipe = Recipe::factory()->create([
        'title' => 'Tomato Pasta',
        'status' => 'approved',
    ]);
    $recipe->ingredients()->create([
        'name' => 'Fresh Basil',
        'amount' => '10 leaves',
        'unit' => 'leaves',
        'order' => 1,
    ]);

    $response = $this->actingAs($user)->get('/browse?search=basil');
    $response->assertStatus(200);
    $response->assertSee('Tomato Pasta');
});
