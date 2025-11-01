<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'photo_path',
        'cook_time',
        'difficulty',
        'servings',
        'cuisine_type',
        'category',
        'dietary_tags',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'dietary_tags' => 'array',
        'cook_time' => 'integer',
        'servings' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class)->orderBy('order');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(RecipeStep::class)->orderBy('step_number');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function savedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_saved_recipes')
            ->withTimestamps();
    }

    // Scopes
    public function scopePrivate($query)
    {
        return $query->where('status', 'private');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopePublic($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Search recipes by title, description, or ingredient names.
     */
    public function scopeSearch($query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        // Escape LIKE wildcards to prevent wildcard injection
        $sanitizedTerm = \App\Helpers\SearchHelper::escapeLikeWildcards($term);

        return $query->where(function ($q) use ($sanitizedTerm) {
            $q->where('title', 'LIKE', "%{$sanitizedTerm}%")
              ->orWhere('description', 'LIKE', "%{$sanitizedTerm}%")
              ->orWhereHas('ingredients', function ($ingredientQuery) use ($sanitizedTerm) {
                  $ingredientQuery->where('name', 'LIKE', "%{$sanitizedTerm}%");
              });
        });
    }

    /**
     * Filter recipes by difficulty level.
     */
    public function scopeByDifficulty($query, $difficulties): Builder
    {
        if (empty($difficulties)) {
            return $query;
        }

        $difficulties = is_array($difficulties) ? $difficulties : [$difficulties];
        return $query->whereIn('difficulty', $difficulties);
    }

    /**
     * Filter recipes by cook time range.
     */
    public function scopeByCookTime($query, $ranges): Builder
    {
        if (empty($ranges)) {
            return $query;
        }

        $ranges = is_array($ranges) ? $ranges : [$ranges];

        return $query->where(function ($q) use ($ranges) {
            foreach ($ranges as $range) {
                match ($range) {
                    'quick' => $q->orWhereBetween('cook_time', [0, 15]),
                    'medium' => $q->orWhereBetween('cook_time', [16, 30]),
                    'long' => $q->orWhereBetween('cook_time', [31, 60]),
                    'very_long' => $q->orWhere('cook_time', '>', 60),
                    default => null,
                };
            }
        });
    }

    /**
     * Filter recipes by meal type (category).
     */
    public function scopeByMealType($query, $mealTypes): Builder
    {
        if (empty($mealTypes)) {
            return $query;
        }

        $mealTypes = is_array($mealTypes) ? $mealTypes : [$mealTypes];
        return $query->whereIn('category', $mealTypes);
    }

    /**
     * Filter recipes by cuisine type.
     */
    public function scopeByCuisine($query, $cuisines): Builder
    {
        if (empty($cuisines)) {
            return $query;
        }

        $cuisines = is_array($cuisines) ? $cuisines : [$cuisines];
        return $query->whereIn('cuisine_type', $cuisines);
    }

    /**
     * Filter recipes by dietary tags (must have ALL selected tags).
     */
    public function scopeByDietaryTags($query, $tags): Builder
    {
        if (empty($tags)) {
            return $query;
        }

        $tags = is_array($tags) ? $tags : [$tags];

        foreach ($tags as $tag) {
            $query->whereJsonContains('dietary_tags', $tag);
        }

        return $query;
    }

    // Status transition methods
    public function submitForApproval(): bool
    {
        if (!in_array($this->status, ['private', 'rejected'])) {
            return false;
        }

        // Verified users bypass pending approval
        if ($this->user->is_verified) {
            $this->status = 'approved';
        } else {
            $this->status = 'pending';
        }

        $this->rejection_reason = null;
        return $this->save();
    }

    public function approve(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $this->status = 'approved';
        return $this->save();
    }

    public function reject(string $reason): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $this->status = 'rejected';
        $this->rejection_reason = $reason;
        return $this->save();
    }

    public function withdraw(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        $this->status = 'private';
        return $this->save();
    }

    // Accessors
    protected function likePercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Use withCount aggregates if loaded, otherwise fall back to queries
                $totalLikes = $this->likes_count ?? $this->likes()->count();
                if ($totalLikes === 0) {
                    return 0;
                }

                $likes = $this->likes_like_count ?? $this->likes()->where('is_like', true)->count();
                return round(($likes / $totalLikes) * 100, 1);
            }
        )->shouldCache();
    }

    protected function dislikePercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Use withCount aggregates if loaded, otherwise fall back to queries
                $totalLikes = $this->likes_count ?? $this->likes()->count();
                if ($totalLikes === 0) {
                    return 0;
                }

                $dislikes = $this->likes_dislike_count ?? $this->likes()->where('is_like', false)->count();
                return round(($dislikes / $totalLikes) * 100, 1);
            }
        )->shouldCache();
    }

    /**
     * Toggle recipe privacy status between private and approved.
     */
    public function togglePrivacy(): bool
    {
        if (!in_array($this->status, ['private', 'approved'])) {
            throw new \InvalidArgumentException('Can only toggle between private and approved status');
        }

        $this->status = $this->status === 'private' ? 'approved' : 'private';
        return $this->save();
    }
}
