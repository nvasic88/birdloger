<?php

namespace App\Notifications;

use App\PoachingObservation;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PoachingObservationEdited extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\User
     */
    public $causer;

    /**
     * @var \App\PoachingObservation
     */
    public $poachingObservation;

    /**
     * Create a new notification instance.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @param \App\User $causer
     * @return void
     */
    public function __construct(PoachingObservation $poachingObservation, User $causer)
    {
        $this->causer = $causer;
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

        if ($notifiable->settings()->get('notifications.field_observation_edited.database')) {
            $channels = array_merge($channels, ['broadcast', 'database']);
        }

        if ($notifiable->settings()->get('notifications.field_observation_edited.mail')) {
            $channels = array_merge($channels, [Channels\UnreadSummaryMailChannel::class]);
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
            'causer_name' => $this->causer->full_name,
            'taxon_name' => optional($this->poachingObservation->observation->taxon)->name,
        ];
    }

    /**
     * Format data for summary mail.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toUnreadSummaryMail($notifiable)
    {
        $taxon = $this->poachingObservation->taxon;

        return [
            'message' => $taxon
                ? trans('notifications.field_observations.edited_message_with_taxon', ['taxonName' => $taxon->name])
                : trans('notifications.field_observations.edited_message'),
            'actionText' => trans('notifications.field_observations.action'),
            'actionUrl' => route('contributor.poaching-observations.show', $this->poachingObservation),
        ];
    }
}
