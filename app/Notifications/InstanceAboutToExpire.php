<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("Your Token is about to Expire:")
            ->line($this->details->name . " days Left to expire: " . $this->days)
            ->line('Please contact with support to assist you with renovation.')
            ->line('If failed to renew, we will be unable to manage your customers subscriptions.')
            ->line('Thank you');
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
