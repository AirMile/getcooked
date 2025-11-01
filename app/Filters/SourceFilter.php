<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Filter for recipes in collection page by source (own recipes or saved recipes).
 *
 * This invokable filter class handles complex logic for combining different recipe sources
 * based on ownership and saved status. It supports multiselect filtering where users can
 * choose to view different combinations of their own recipes and saved recipes.
 */
class SourceFilter
{
    /**
     * Apply source filtering for collection page.
     *
     * Handles multiselect combinations of recipe sources:
     * - own_public: User's own public/approved recipes
     * - own_private: User's own private recipes
     * - saved: Recipes saved by the user (from other users)
     *
     * When no sources are specified, defaults to showing all user recipes and saved recipes.
     *
     * Logic examples:
     * - ['own_public'] → Only user's approved recipes
     * - ['own_private'] → Only user's private recipes
     * - ['own_public', 'own_private'] → All user's own recipes regardless of status
     * - ['saved'] → Only recipes saved from other users
     * - ['own_public', 'saved'] → User's approved recipes + saved recipes
     * - [] → Default: All own recipes + all saved recipes
     *
     * @param Builder $query The Eloquent query builder instance
     * @param array $sources Array of source filters ('own_public', 'own_private', 'saved')
     * @param int $userId The ID of the authenticated user
     * @return Builder The modified query builder with source filters applied
     */
    public function __invoke(Builder $query, array $sources, int $userId): Builder
    {
        if (empty($sources)) {
            // Default: show all (own recipes + saved recipes)
            return $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhereHas('savedByUsers', function ($savedQuery) use ($userId) {
                      $savedQuery->where('user_id', $userId);
                  });
            });
        }

        return $query->where(function ($q) use ($sources, $userId) {
            $hasOwnPublic = in_array('own_public', $sources);
            $hasOwnPrivate = in_array('own_private', $sources);
            $hasSaved = in_array('saved', $sources);

            // Build conditions based on selected sources
            if ($hasOwnPublic || $hasOwnPrivate) {
                $q->where(function ($ownQuery) use ($hasOwnPublic, $hasOwnPrivate, $userId) {
                    $ownQuery->where('user_id', $userId);

                    if ($hasOwnPublic && !$hasOwnPrivate) {
                        $ownQuery->where('status', 'approved');
                    } elseif ($hasOwnPrivate && !$hasOwnPublic) {
                        $ownQuery->where('status', 'private');
                    }
                    // If both selected, no additional status filter needed
                });
            }

            // Add saved recipes if selected
            if ($hasSaved) {
                if ($hasOwnPublic || $hasOwnPrivate) {
                    $q->orWhereHas('savedByUsers', function ($savedQuery) use ($userId) {
                        $savedQuery->where('user_id', $userId);
                    });
                } else {
                    $q->whereHas('savedByUsers', function ($savedQuery) use ($userId) {
                        $savedQuery->where('user_id', $userId);
                    });
                }
            }
        });
    }
}
