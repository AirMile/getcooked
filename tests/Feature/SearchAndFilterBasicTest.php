<?php

use App\Models\Recipe;
use App\Models\User;

test('browse page shows only approved recipes', function () {
    $user = User::factory()->create();

    $approvedRecipe = Recipe::factory()->create(['status' => 'approved']);
    $privateRecipe = Recipe::factory()->create(['status' => 'private']);

    $response = $this->actingAs($user)->get(route('browse'));

    $response->assertOk();
});

test('collection page shows user own recipes', function () {
    $user = User::factory()->create();

    $ownRecipe = Recipe::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get(route('collection'));

    $response->assertOk();
});

test('search parameter filters recipes', function () {
    $user = User::factory()->create();

    $matchingRecipe = Recipe::factory()->create([
        'title' => 'Delicious Pasta',
        'status' => 'approved',
    ]);

    $response = $this->actingAs($user)->get(route('browse', ['search' => 'pasta']));

    $response->assertOk();
});
