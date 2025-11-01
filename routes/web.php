<?php

use App\Http\Controllers\AdminRecipeController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Only the landing page should be accessible without authentication.
| All other application routes must be protected with auth middleware.
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
| All application routes below require authentication.
| Add new feature routes inside the middleware group.
*/

// Browse public approved recipes with search and filters
Route::get('/browse', [BrowseController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('browse');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Collection: user's own recipes and saved recipes with filters
    Route::get('/collection', [CollectionController::class, 'index'])->name('collection');

    // Recipe CRUD (except index, which is now 'collection')
    Route::resource('recipes', RecipeController::class)->except(['index']);

    // Status transitions
    Route::post('recipes/{recipe}/submit', [RecipeController::class, 'submit'])
        ->name('recipes.submit');
    Route::post('recipes/{recipe}/withdraw', [RecipeController::class, 'withdraw'])
        ->name('recipes.withdraw');

    // Social features (with rate limiting)
    Route::middleware('throttle:recipe-interactions')->group(function () {
        Route::post('recipes/{recipe}/like', [RecipeController::class, 'like'])
            ->name('recipes.like');
        Route::post('recipes/{recipe}/dislike', [RecipeController::class, 'dislike'])
            ->name('recipes.dislike');
        Route::post('recipes/{recipe}/save', [RecipeController::class, 'save'])
            ->name('recipes.save');
        Route::delete('recipes/{recipe}/unsave', [RecipeController::class, 'unsave'])
            ->name('recipes.unsave');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Admin moderation and management routes. Protected by auth and admin
| middleware.
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Pending recipes
    Route::get('recipes/pending', [AdminRecipeController::class, 'pending'])
        ->name('recipes.pending');
    Route::post('recipes/{recipe}/approve', [AdminRecipeController::class, 'approve'])
        ->name('recipes.approve');
    Route::post('recipes/{recipe}/reject', [AdminRecipeController::class, 'reject'])
        ->name('recipes.reject');

    // Public recipes moderation
    Route::get('recipes/public', [AdminRecipeController::class, 'public'])
        ->name('recipes.public');
    Route::delete('recipes/{recipe}/moderate', [AdminRecipeController::class, 'moderate'])
        ->name('recipes.moderate');

    // User management
    Route::get('users', [AdminRecipeController::class, 'users'])
        ->name('users.index');
    Route::get('users/{user}/recipes', [AdminRecipeController::class, 'userRecipes'])
        ->name('users.recipes');

    // User verified status toggle
    Route::post('users/{user}/toggle-verified', [AdminUserController::class, 'toggleVerified'])
        ->name('users.toggle-verified');

    // Recipe privacy toggle
    Route::post('recipes/{recipe}/toggle-privacy', [AdminUserController::class, 'toggleRecipePrivacy'])
        ->name('recipes.toggle-privacy');
});

require __DIR__.'/auth.php';
