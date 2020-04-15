<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Event;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\MsTeams\MsTeamsChannel;
use NotificationChannels\MsTeams\MsTeamsMessage;
use Illuminate\Notifications\Messages\MailMessage;

class FailedJob extends Notification
{

    
    use Queueable;
    
    public $event;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobFailed $event)
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
        return [MsTeamsChannel::class];
    }

    public function toMsTeams($notifiable)
    {
        return MsTeamsMessage::create()
            ->to(config('services.ms-teams.webhook_url'))
            ->title('Job failed with id '.$this->event->job->getJobId())
            ->content(  ">**Job UUID:** " . $this->event->job->uuid()."<br/>".
                        "**Job ID:**    " . $this->event->job->getJobId()."<br/>".
                        "**Job Name:**  ". $this->event->job->resolveName()."<br/>".
                        "**Attempts:**  ". $this->event->job->attempts()."<br/>".
                        "**Message Body:**  ". $this->event->exception->getMessage())
            ->button('Please check it' ,'app()->environment()');
            // ->image('https://source.unsplash.com/random/800x800?animals,nature&q='.now()
        ;
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
