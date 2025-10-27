<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Like;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    /**
     * Display listing of user's own recipes and public recipes.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // User's own recipes (all statuses)
        $myRecipes = Recipe::where('user_id', $user->id)
            ->with(['ingredients'])
            ->withCount([
                'likes',
                'likes as likes_like_count' => fn($q) => $q->where('is_like', true),
                'likes as likes_dislike_count' => fn($q) => $q->where('is_like', false)
            ])
            ->latest()
            ->get();

        // Public approved recipes
        $publicRecipes = Recipe::approved()
            ->where('user_id', '!=', $user->id)
            ->with(['user', 'ingredients'])
            ->withCount([
                'likes',
                'likes as likes_like_count' => fn($q) => $q->where('is_like', true),
                'likes as likes_dislike_count' => fn($q) => $q->where('is_like', false)
            ])
            ->latest()
            ->paginate(12);

        return view('recipes.index', compact('myRecipes', 'publicRecipes'));
    }

    /**
     * Show the form for creating a new recipe.
     */
    public function create()
    {
        $this->authorize('create', Recipe::class);

        return view('recipes.create');
    }

    /**
     * Store a newly created recipe.
     */
    public function store(StoreRecipeRequest $request)
    {
        $validated = $request->validated();

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('recipes', 'public');
        }

        // Create recipe
        $recipe = $request->user()->recipes()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'photo_path' => $photoPath,
            'cook_time' => $validated['cook_time'],
            'difficulty' => $validated['difficulty'],
            'servings' => $validated['servings'],
            'cuisine_type' => $validated['cuisine_type'] ?? null,
            'category' => $validated['category'] ?? null,
            'dietary_tags' => $validated['dietary_tags'] ?? [],
            'status' => 'private',
        ]);

        // Create ingredients
        foreach ($validated['ingredients'] as $index => $ingredient) {
            $recipe->ingredients()->create([
                'name' => $ingredient['name'],
                'amount' => $ingredient['amount'],
                'unit' => $ingredient['unit'],
                'order' => $index,
            ]);
        }

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recipe created successfully!');
    }

    /**
     * Display the specified recipe.
     */
    public function show(Recipe $recipe)
    {
        $this->authorize('view', $recipe);

        $recipe->load(['user', 'ingredients', 'likes']);

        $userLike = null;
        if (auth()->check()) {
            $userLike = $recipe->likes()
                ->where('user_id', auth()->id())
                ->first();
        }

        $isSaved = auth()->check()
            ? auth()->user()->savedRecipes()->where('recipe_id', $recipe->id)->exists()
            : false;

        return view('recipes.show', compact('recipe', 'userLike', 'isSaved'));
    }

    /**
     * Show the form for editing the specified recipe.
     */
    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $recipe->load('ingredients');

        return view('recipes.edit', compact('recipe'));
    }

    /**
     * Update the specified recipe.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $validated = $request->validated();

        // Handle photo upload
        $photoPath = $recipe->photo_path;
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($recipe->photo_path && Storage::disk('public')->exists($recipe->photo_path)) {
                Storage::disk('public')->delete($recipe->photo_path);
            }
            $photoPath = $request->file('photo')->store('recipes', 'public');
        }

        // Update recipe
        $recipe->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'photo_path' => $photoPath,
            'cook_time' => $validated['cook_time'],
            'difficulty' => $validated['difficulty'],
            'servings' => $validated['servings'],
            'cuisine_type' => $validated['cuisine_type'] ?? null,
            'category' => $validated['category'] ?? null,
            'dietary_tags' => $validated['dietary_tags'] ?? [],
        ]);

        // If approved recipe is edited by non-admin user
        // Verified users keep approved status, standard users go to pending
        if ($recipe->status === 'approved' && $request->user()->role !== 'admin') {
            if (!$request->user()->is_verified) {
                $recipe->update(['status' => 'pending']);
            }
        }

        // Update ingredients (delete old, create new)
        $recipe->ingredients()->delete();
        foreach ($validated['ingredients'] as $index => $ingredient) {
            $recipe->ingredients()->create([
                'name' => $ingredient['name'],
                'amount' => $ingredient['amount'],
                'unit' => $ingredient['unit'],
                'order' => $index,
            ]);
        }

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recipe updated successfully!');
    }

    /**
     * Remove the specified recipe.
     */
    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);

        // Delete photo if exists
        if ($recipe->photo_path && Storage::disk('public')->exists($recipe->photo_path)) {
            Storage::disk('public')->delete($recipe->photo_path);
        }

        $recipe->delete();

        return redirect()->route('recipes.index')
            ->with('success', 'Recipe deleted successfully!');
    }

    /**
     * Submit recipe for approval.
     */
    public function submit(Recipe $recipe)
    {
        $this->authorize('submitForApproval', $recipe);

        if ($recipe->submitForApproval()) {
            return back()->with('success', 'Recipe submitted for approval!');
        }

        return back()->with('error', 'Unable to submit recipe for approval.');
    }

    /**
     * Withdraw recipe from pending approval.
     */
    public function withdraw(Recipe $recipe)
    {
        $this->authorize('withdraw', $recipe);

        if ($recipe->withdraw()) {
            return back()->with('success', 'Recipe withdrawn from approval queue.');
        }

        return back()->with('error', 'Unable to withdraw recipe.');
    }

    /**
     * Like a recipe.
     */
    public function like(Request $request, Recipe $recipe)
    {
        $user = $request->user();

        Like::updateOrCreate(
            [
                'user_id' => $user->id,
                'likeable_id' => $recipe->id,
                'likeable_type' => Recipe::class,
            ],
            ['is_like' => true]
        );

        return back()->with('success', 'Recipe liked!');
    }

    /**
     * Dislike a recipe.
     */
    public function dislike(Request $request, Recipe $recipe)
    {
        $user = $request->user();

        Like::updateOrCreate(
            [
                'user_id' => $user->id,
                'likeable_id' => $recipe->id,
                'likeable_type' => Recipe::class,
            ],
            ['is_like' => false]
        );

        return back()->with('success', 'Recipe disliked.');
    }

    /**
     * Save recipe to user's library.
     */
    public function save(Request $request, Recipe $recipe)
    {
        $user = $request->user();

        if (!$user->savedRecipes()->where('recipe_id', $recipe->id)->exists()) {
            $user->savedRecipes()->attach($recipe->id);
        }

        return back()->with('success', 'Recipe saved to your library!');
    }

    /**
     * Remove recipe from user's library.
     */
    public function unsave(Request $request, Recipe $recipe)
    {
        $user = $request->user();

        $user->savedRecipes()->detach($recipe->id);

        return back()->with('success', 'Recipe removed from your library.');
    }
}
