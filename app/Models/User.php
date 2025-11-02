<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
            'is_verified' => 'boolean',
        ];
    }

    // Relationships
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function savedRecipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'user_saved_recipes')
            ->withTimestamps();
    }

    /**
     * Toggle the user's verified status.
     */
    public function toggleVerified(): void
    {
        $this->is_verified = !$this->is_verified;
        $this->save();
    }

    /**
     * Get cached count of unread notifications.
     * Cache expires after 5 minutes to balance performance and freshness.
     */
    public function getCachedUnreadNotificationsCount(): int
    {
        return Cache::remember(
            "user_{$this->id}_unread_notifications_count",
            now()->addMinutes(5),
            fn() => $this->unreadNotifications()->count()
        );
    }
}
