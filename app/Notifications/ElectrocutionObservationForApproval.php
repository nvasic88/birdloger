<?php

namespace App\Notifications;

use App\ElectrocutionObservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ElectrocutionObservationForApproval extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\ElectrocutionObservation
     */
    public $electrocutionObservation;

    /**
     * Create a new notification instance.
     *
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return void
     */
    public function __construct(ElectrocutionObservation $electrocutionObservation)
    {
        $this->electrocutionObservation = $electrocutionObservation;
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
            'field_observation_id' => $this->electrocutionObservation->id,
            'contributor_name' => $this->electrocutionObservation->creatorName(),
        ];
    }
}
