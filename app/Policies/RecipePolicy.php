<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    /**
     * Determine if the user can view any recipes.
     * Public recipes are visible to all users.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Everyone can see public recipes
    }

    /**
     * Determine if the user can view the recipe.
     * Owner can view own recipes regardless of status.
     * Others can only view approved public recipes.
     */
    public function view(?User $user, Recipe $recipe): bool
    {
        // Public approved recipes visible to all
        if ($recipe->status === 'approved') {
            return true;
        }

        // Must be authenticated to view private/pending/rejected
        if (!$user) {
            return false;
        }

        // Owner can view their own recipes
        return $user->id === $recipe->user_id;
    }

    /**
     * Determine if the user can create recipes.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create
    }

    /**
     * Determine if the user can update the recipe.
     * Owner can update private or rejected recipes.
     * Owner cannot update pending recipes (must withdraw first).
     * Admin can update any recipe without status restrictions.
     */
    public function update(User $user, Recipe $recipe): bool
    {
        // Must be owner
        if ($user->id !== $recipe->user_id) {
            return false;
        }

        // Cannot edit pending recipes (must withdraw first)
        if ($recipe->status === 'pending') {
            return false;
        }

        return true;
    }

    /**
     * Determine if the user can delete the recipe.
     * Owner can delete own recipes.
     * Admin can delete any recipe.
     */
    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id;
    }

    /**
     * Determine if the user can submit recipe for approval.
     * Only owner can submit private or rejected recipes.
     */
    public function submitForApproval(User $user, Recipe $recipe): bool
    {
        if ($user->id !== $recipe->user_id) {
            return false;
        }

        return in_array($recipe->status, ['private', 'rejected']);
    }

    /**
     * Determine if the user can withdraw a pending recipe.
     * Only owner can withdraw pending recipes.
     */
    public function withdraw(User $user, Recipe $recipe): bool
    {
        if ($user->id !== $recipe->user_id) {
            return false;
        }

        return $recipe->status === 'pending';
    }

    /**
     * Determine if the user can approve recipes.
     * Only admins can approve (handled by Gate::before).
     */
    public function approve(User $user, Recipe $recipe): bool
    {
        return false; // Admin bypass in Gate::before
    }

    /**
     * Determine if the user can reject recipes.
     * Only admins can reject (handled by Gate::before).
     */
    public function reject(User $user, Recipe $recipe): bool
    {
        return false; // Admin bypass in Gate::before
    }
}
