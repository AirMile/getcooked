<?php

namespace App\Http\Controllers;

use App\Filters\SourceFilter;
use App\Http\Requests\CollectionRequest;
use App\Models\Recipe;

class CollectionController extends Controller
{
    /**
     * Display user's own recipes and saved recipes with search and filters.
     */
    public function index(CollectionRequest $request)
    {
        $user = $request->user();

        $query = Recipe::query()
            ->with('user') // Only eager load user; ingredients not needed in card view
            ->withCount([
                'likes as likes_count',
                'likes as likes_like_count' => fn($q) => $q->where('is_like', true),
                'likes as likes_dislike_count' => fn($q) => $q->where('is_like', false),
            ]);

        // Apply source filter (own public, own private, saved)
        $sources = $request->input('source', []);
        // Ensure sources is always an array (defensive programming)
        if (!is_array($sources)) {
            $sources = [$sources];
        }
        $sourceFilter = new SourceFilter();
        $query = $sourceFilter($query, $sources, $user->id);

        // Apply search
        $query->when($request->input('search'), function ($q, $search) {
            $q->search($search);
        });

        // Apply filters (subset of browse filters)
        $query->when($request->input('difficulty'), function ($q, $difficulty) {
            $q->byDifficulty($difficulty);
        });

        $query->when($request->input('cook_time'), function ($q, $cookTime) {
            $q->byCookTime($cookTime);
        });

        $query->when($request->input('meal_type'), function ($q, $mealType) {
            $q->byMealType($mealType);
        });

        // Order by newest first
        $query->orderBy('created_at', 'desc');

        // Paginate with query string to maintain filters
        $recipes = $query->paginate(15)->withQueryString();

        // Get filter values for UI state
        $filters = [
            'search' => $request->input('search'),
            'source' => $sources,
            'difficulty' => $request->input('difficulty', []),
            'cook_time' => $request->input('cook_time', []),
            'meal_type' => $request->input('meal_type', []),
        ];

        return view('collection', compact('recipes', 'filters'));
    }
}
