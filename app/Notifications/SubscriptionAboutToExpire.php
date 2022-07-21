<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Mail\SubscriptionAlertRenew;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;

class SubscriptionAboutToExpire extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details, $days)
    {
        $this->days = $days;
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return explode(',', $notifiable->notifications_preferences);
    }

    public function toMicrosoftTeams($notifiable)
    {
        return MicrosoftTeamsMessage::create()
        ->to($notifiable->teams_webhook)
        ->type('success')
        ->title('Renew your Microsoft subscriptions to avoid disruption')
        ->content('You have 1 expired subscriptions that will be disabled on **'. date('j F, Y', strtotime($this->details->expiration_data)) .
        '** To avoid disruption, renew your subscriptions in **Tagydes Portal** by that date.')
        ->button('Check Subscription', $this->details->format()['path']);
        logger('TeamsWebhook '. $notifiable->teams_webhook);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = new \App\Mail\SubscriptionAlertRenew($this->details);
        return $mail->locale($notifiable->locale)->to($notifiable->email);
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
            'data' => trans('mail.title_your_microsoft_subscriptions', [
                    'Expiration Date' => date('j F, Y', strtotime($this->details->expiration_data)),
                ]
            )
        ];
    }
}
