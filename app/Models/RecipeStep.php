<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Recipe Step Model
 *
 * Represents an individual preparation step within a recipe.
 * Steps are ordered by step_number and displayed as a numbered list.
 *
 * @property int $id
 * @property int $recipe_id
 * @property int $step_number
 * @property string $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Recipe $recipe
 */
class RecipeStep extends Model
{
    use HasFactory;

    /**
     * Validation constants for recipe steps
     */
    public const MIN_STEPS = 1;
    public const MAX_STEPS = 25;
    public const MAX_DESCRIPTION_LENGTH = 1000;

    protected $fillable = [
        'recipe_id',
        'step_number',
        'description',
    ];

    /**
     * Touch parent recipe when steps are updated
     *
     * @var array<int, string>
     */
    protected $touches = ['recipe'];

    /**
     * Get the recipe that owns this step.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Recipe, \App\Models\RecipeStep>
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
