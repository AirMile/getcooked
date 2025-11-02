<?php

namespace App\Notifications;

use App\Models\Recipe;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RecipeRejectedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Recipe $recipe,
        public string $rejectionReason
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
            'recipe_id' => $this->recipe->id,
            'recipe_title' => $this->recipe->title,
            'status' => 'rejected',
            'rejection_reason' => $this->rejectionReason,
            'message' => "Your recipe '{$this->recipe->title}' was not approved.",
            'action_url' => route('recipes.edit', $this->recipe),
        ];
    }
}
