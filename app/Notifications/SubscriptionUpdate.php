<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;

class SubscriptionUpdate extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // dd(explode(',', $notifiable->notifications_preferences));

        // return ['database','mail','msteams' ];
        return explode(',', $notifiable->notifications_preferences);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $status = $this->subscription->status_id == 1 ? 'Running' : 'Suspended';

        return (new MailMessage)
            ->line('Subscription ' . $this->subscription->name . ' changed status to '.$status)
            ->line('Please review this information in your dashboard')
            ->line('Thank you for using our application!');
            // ->action('Notification Action', url(''))
    }

    public function toMicrosoftTeams($notifiable)
    {
        logger('TeamsWebhook '. $notifiable->teams_webhook);

        $status = $this->subscription->status_id == 1 ? 'Running' : 'Suspended';
        if($status == 'Running'){
            $type = 'success';
        }else{
            $type = 'error';
        }
        return MicrosoftTeamsMessage::create()
            ->to($notifiable->teams_webhook)
            ->type($type)
            ->title('Subscription Updated')
            ->content('Subscription ' . $this->subscription->name . ' changed status to '.$status);
            // ->button('Check User', 'https://foo.bar/users/123');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $status = $this->subscription->status_id == 1 ? 'Running' : 'Suspended';
        return [
            'data' => "Subscription " . $this->subscription->name . " changed status to ". $status
        ];

    }
}
