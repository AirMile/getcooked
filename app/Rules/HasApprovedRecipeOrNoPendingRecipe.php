<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Support\Facades\Auth;

class HasApprovedRecipeOrNoPendingRecipe implements ValidationRule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = Auth::user();

        if (!$user) {
            return; // No user authenticated, let authorization handle it
        }

        // If user has approved recipe, they're unlocked - validation passes
        if ($this->userHasApprovedRecipes($user)) {
            return;
        }

        // User has no approved recipes - check pending count
        $pendingCount = $this->getUserPendingRecipesCount($user);

        // If user already has 1 or more pending recipes, fail validation
        if ($pendingCount >= 1) {
            $fail('You must wait for your first recipe to be approved before uploading more recipes.');
        }
    }

    /**
     * Check if user has any approved recipes.
     */
    protected function userHasApprovedRecipes($user): bool
    {
        return $user->recipes()
            ->where('status', 'approved')
            ->exists();
    }

    /**
     * Get the count of user's pending recipes.
     */
    protected function getUserPendingRecipesCount($user): int
    {
        return $user->recipes()
            ->where('status', 'pending')
            ->count();
    }
}
