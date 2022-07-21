<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;

class InstanceAboutToExpire extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function  __construct($details, $days)
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
        ->title('Renew your Microsoft instance to avoid disruption')
        ->content('You have 1 expired instance that will stop working on **'. date("Y-m-d", strtotime($this->details->external_token_updated_at->modify('+90 days'))) .
        '** To avoid disruption, renew your instance in **Tagydes Portal** by that date.');
        // ->button('Check Subscription', $this->details->format()['path']);
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
        $mail = new \App\Mail\InstanceAlertRenew($this->details);
        return $mail->to($notifiable->email);
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
            'data' => "Instance token is about to expire: ".$this->details->name. " days Left to expire: " . $this->days ." please update the token before expires."
        ];
    }
}
