<?php

namespace App\Notifications;

use App\PoachingObservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PoachingObservationForApproval extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\PoachingObservation
     */
    public $poachingObservation;

    /**
     * Create a new notification instance.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @return void
     */
    public function __construct(PoachingObservation $poachingObservation)
    {
        $this->poachingObservation = $poachingObservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [];

        if ($notifiable->settings()->get('notifications.field_observation_for_approval.database')) {
            $channels = array_merge($channels, ['broadcast', 'database']);
        }

        return $channels;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'field_observation_id' => $this->poachingObservation->id,
            'contributor_name' => $this->poachingObservation->creatorName(),
        ];
    }
}
