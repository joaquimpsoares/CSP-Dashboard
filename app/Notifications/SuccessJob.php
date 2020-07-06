<?php

namespace App\Notifications;

use App\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\MsTeams\MsTeamsChannel;
use NotificationChannels\MsTeams\MsTeamsMessage;
use Illuminate\Notifications\Messages\MailMessage;

class SuccessJob extends Notification
{
    use Queueable;

    public $event;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobProcessed $event)
    {
        $this->event = $event;
    
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return explode(', ', $notifiable->notifications_preferences);
        // return ['msteams', 'mail', 'database'];
    }

    public function toMsTeams($notifiable)
    {

        $customer = Customer::get();
        return MsTeamsMessage::create()
            ->to(config('services.ms-teams.webhook_url'))
            ->title('Job with id ' . $this->event->job->getJobId().  ' was successfully run')
            ->content(  ">**Job UUID:** " . $this->event->job->uuid()."<br/>".
                        "**Job ID:**    " . $this->event->job->getJobId()."<br/>".
                        "**Job Name:**  ". $this->event->job->resolveName()."<br/>".
                        "**Attempts:**  ". $this->event->job->attempts()."<br/>".
                        // "**Message Body:**  ". $this->event->job->getRawBody())
                        "**Message Body:**  ". $this->event)
                        // "teste" .$this->customer() ."<br/>".
            ->button('Please check it' ,'app()->environment()');
            // ->image('https://source.unsplash.com/random/800x800?animals,nature&q='.now()


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
