<?php

namespace App\Notifications;

use App\Models\Recipe;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RecipeApprovedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Recipe $recipe
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
            'status' => 'approved',
            'message' => "Your recipe '{$this->recipe->title}' has been approved and is now public!",
            'action_url' => route('recipes.show', $this->recipe),
        ];
    }
}
