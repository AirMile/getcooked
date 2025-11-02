<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use App\Notifications\RecipeApprovedNotification;
use App\Notifications\RecipeRejectedNotification;
use App\Notifications\RecipeDeletedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRecipeController extends Controller
{
    /**
     * Display pending recipes dashboard.
     */
    public function pending(Request $request)
    {
        $query = Recipe::pending()
            ->with(['user', 'ingredients']);

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // User filter
        if ($userId = $request->input('user_id')) {
            $query->where('user_id', $userId);
        }

        $pendingRecipes = $query->latest()->paginate(20);

        // Statistics
        $stats = [
            'pending' => Recipe::pending()->count(),
            'approved' => Recipe::approved()->count(),
            'rejected' => Recipe::rejected()->count(),
            'total' => Recipe::count(),
        ];

        return view('admin.recipes.pending', compact('pendingRecipes', 'stats'));
    }

    /**
     * Approve a pending recipe.
     */
    public function approve(Recipe $recipe)
    {
        $this->authorize('approve', $recipe);

        if ($recipe->approve()) {
            // Send notification to recipe owner
            $recipe->user->notify(new RecipeApprovedNotification($recipe));

            return back()->with('success', "Recipe '{$recipe->title}' approved successfully!");
        }

        return back()->with('error', 'Unable to approve recipe. It must be in pending status.');
    }

    /**
     * Reject a pending recipe with reason.
     */
    public function reject(Request $request, Recipe $recipe)
    {
        $this->authorize('reject', $recipe);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if ($recipe->reject($validated['rejection_reason'])) {
            // Send notification to recipe owner
            $recipe->user->notify(new RecipeRejectedNotification($recipe, $validated['rejection_reason']));

            return back()->with('success', "Recipe '{$recipe->title}' rejected.");
        }

        return back()->with('error', 'Unable to reject recipe. It must be in pending status.');
    }

    /**
     * Display public recipes for moderation.
     */
    public function public(Request $request)
    {
        $query = Recipe::approved()
            ->with(['user', 'likes']);

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort by likes
        if ($request->input('sort') === 'popular') {
            $query->withCount('likes')->orderBy('likes_count', 'desc');
        } else {
            $query->latest();
        }

        $publicRecipes = $query->paginate(20);

        return view('admin.recipes.public', compact('publicRecipes'));
    }

    /**
     * Delete inappropriate public recipe with reason.
     */
    public function moderate(Request $request, Recipe $recipe)
    {
        $this->authorize('delete', $recipe);

        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        // Store moderation log (optional - could be separate table)
        // ModerationLog::create([...])

        // Delete photo if exists
        if ($recipe->photo_path && Storage::disk('public')->exists($recipe->photo_path)) {
            Storage::disk('public')->delete($recipe->photo_path);
        }

        // Store recipe data before deletion for notification
        $title = $recipe->title;
        $recipeOwner = $recipe->user;

        $recipe->delete();

        // Send notification to recipe owner
        $recipeOwner->notify(new RecipeDeletedNotification($title, $validated['reason']));

        return back()->with('success', "Recipe '{$title}' deleted. Reason: {$validated['reason']}");
    }

    /**
     * Display users and their recipe counts.
     */
    public function users()
    {
        $users = User::has('recipes')
            ->withCount('recipes')
            ->orderByDesc('recipes_count')
            ->paginate(20);

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Display specific user's recipes.
     */
    public function userRecipes(User $user)
    {
        $recipes = $user->recipes()
            ->with('ingredients')
            ->latest()
            ->paginate(20);

        return view('admin.users.recipes', compact('user', 'recipes'));
    }
}
