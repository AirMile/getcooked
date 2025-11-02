<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrowseRequest;
use App\Models\Recipe;

class BrowseController extends Controller
{
    /**
     * Display public approved recipes with search and filters.
     */
    public function index(BrowseRequest $request)
    {
        $query = Recipe::approved()
            ->where('user_id', '!=', auth()->id()) // Exclude own recipes
            ->with('user')
            ->withCount([
                'likes as likes_count',
                'likes as likes_like_count' => fn($q) => $q->where('is_like', true),
                'likes as likes_dislike_count' => fn($q) => $q->where('is_like', false),
            ]);

        // Apply search
        $query->when($request->input('search'), function ($q, $search) {
            $q->search($search);
        });

        // Apply filters
        $query->when($request->input('difficulty'), function ($q, $difficulty) {
            $q->byDifficulty($difficulty);
        });

        $query->when($request->input('cook_time'), function ($q, $cookTime) {
            $q->byCookTime($cookTime);
        });

        $query->when($request->input('meal_type'), function ($q, $mealType) {
            $q->byMealType($mealType);
        });

        $query->when($request->input('cuisine'), function ($q, $cuisine) {
            $q->byCuisine($cuisine);
        });

        $query->when($request->input('dietary_tags'), function ($q, $tags) {
            $q->byDietaryTags($tags);
        });

        // Order by newest first
        $query->orderBy('created_at', 'desc');

        // Paginate with query string to maintain filters
        $recipes = $query->paginate(15)->withQueryString();

        // Get filter values for UI state
        $filters = [
            'search' => $request->input('search'),
            'difficulty' => $request->input('difficulty', []),
            'cook_time' => $request->input('cook_time', []),
            'meal_type' => $request->input('meal_type', []),
            'cuisine' => $request->input('cuisine', []),
            'dietary_tags' => $request->input('dietary_tags', []),
        ];

        return view('browse', compact('recipes', 'filters'));
    }
}
