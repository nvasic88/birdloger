<?php

namespace App\Notifications;

use App\PoachingObservation;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PoachingObservationApproved extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\User
     */
    public $curator;

    /**
     * @var \App\PoachingObservation
     */
    public $poachingObservation;

    /**
     * Create a new notification instance.
     *
     * @param  \App\PoachingObservation  $poachingObservation
     * @param  \App\User  $curator
     * @return void
     */
    public function __construct(PoachingObservation $poachingObservation, User $curator)
    {
        $this->curator = $curator;
        $this->PoachingObservation = $poachingObservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [];

        if ($notifiable->settings()->get('notifications.poaching_observation_approved.database')) {
            $channels = array_merge($channels, ['broadcast', 'database']);
        }

        if ($notifiable->settings()->get('notifications.poaching_observation_approved.mail')) {
            $channels = array_merge($channels, [Channels\UnreadSummaryMailChannel::class]);
        }

        return $channels;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'poaching_observation_id' => $this->PoachingObservation->id,
            'curator_name' => $this->curator->full_name,
            'taxon_name' => optional($this->PoachingObservation->observation->taxon)->name,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * NOTE: No longer used, should be deleted at some point.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(trans('notifications.poaching_observations.approved_subject'))
            ->line(trans('notifications.poaching_observations.approved_message'))
            ->action(
                trans('notifications.poaching_observations.action'),
                route('contributor.poaching-observations.show', $this->PoachingObservation)
            );
    }

    /**
     * Format data for summary mail.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toUnreadSummaryMail($notifiable)
    {
        $taxon = $this->PoachingObservation->taxon;

        return [
            'message' => $taxon
                ? trans('notifications.poaching_observations.approved_message_with_taxon', ['taxonName' => $taxon->name])
                : trans('notifications.poaching_observations.approved_message'),
            'actionText' => trans('notifications.poaching_observations.action'),
            'actionUrl' => route('contributor.poaching-observations.show', $this->PoachingObservation),
        ];
    }
}
