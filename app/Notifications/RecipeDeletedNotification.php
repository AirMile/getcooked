<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RecipeDeletedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $recipeTitle,
        public string $deletionReason
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'recipe_id' => null, // Recipe is deleted, no ID available
            'recipe_title' => $this->recipeTitle,
            'status' => 'deleted',
            'deletion_reason' => $this->deletionReason,
            'message' => "Your recipe '{$this->recipeTitle}' was removed from the platform.",
            'action_url' => route('recipes.create'),
        ];
    }
}
