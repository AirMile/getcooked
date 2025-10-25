<?php

namespace App\Models;

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

    // Status transition methods
    public function submitForApproval(): bool
    {
        if (!in_array($this->status, ['private', 'rejected'])) {
            return false;
        }

        $this->status = 'pending';
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
                $totalLikes = $this->likes()->count();
                if ($totalLikes === 0) {
                    return 0;
                }

                $likes = $this->likes()->where('is_like', true)->count();
                return round(($likes / $totalLikes) * 100, 1);
            }
        );
    }

    protected function dislikePercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                $totalLikes = $this->likes()->count();
                if ($totalLikes === 0) {
                    return 0;
                }

                $dislikes = $this->likes()->where('is_like', false)->count();
                return round(($dislikes / $totalLikes) * 100, 1);
            }
        );
    }
}
