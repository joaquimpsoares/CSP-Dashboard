<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionUpdate extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details)
    {
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
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $status = $this->details->status_id == 1 ? 'Running' : 'Suspended';

        return (new MailMessage)
                    ->line('Subscription ' . $this->details->name . ' changed status to '.$status)
                    ->line('Please review this information in your dashboard')
                    ->line('Thank you for using our application!');
                    // ->action('Notification Action', url(''))
                }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $status = $this->details->status_id == 1 ? 'Running' : 'Suspended';

        return [
            'data' => "Subscription " . $this->details->name . " changed status to ". $status
        ];

    }
}
