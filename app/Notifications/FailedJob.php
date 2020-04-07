<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\MsTeams\MsTeamsChannel;
use NotificationChannels\MsTeams\MsTeamsMessage;
use Illuminate\Notifications\Messages\MailMessage;

class FailedJob extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [MsTeamsChannel::class];
    }

    public function toMsTeams($notifiable)
    {
        // $url = url('/invoice/' . $this->invoice->id);

        return MsTeamsMessage::create()
            ->to(config('services.ms-teams.webhook_url'))
            ->title('Here is a test notification sent from the '.ucfirst(app()->environment()).' environment')
            ->content("Here is some content for the notification.
                > That also supports markdown formatting in the body too!
                Below are optional buttons and images.
            ")
            ->button('And some clickable buttons', 'https://nx-technology.com')
            ->image('https://source.unsplash.com/random/800x800?animals,nature&q='.now());
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            //
        ];
    }
}
