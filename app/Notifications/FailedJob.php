<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Notifications\Notification;
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
        // $msteams = MsTeamsChannel::class;

    return explode(', ', $notifiable->notifications_preferences);
    // return ['msteams', 'mail', 'database'];
    }

    public function toMsTeams($notifiable)
    {
        return MsTeamsMessage::create()
            ->to(config('services.ms-teams.webhook_url'))
            ->title('Job failed with id ' . $this->event->job->getJobId())
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
                    ->line('Job failed with id  '.$this->event->job->getJobId())
                    ->line('**Job UUID:**       ' . $this->event->job->uuid())
                    ->line('**Job ID:**         ' . $this->event->job->getJobId())
                    ->line('**Job Name:**       '. $this->event->job->resolveName())
                    ->line('**Message Body:**   '. $this->event->exception->getMessage())
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'Job UUID' => $this->event->job->uuid(),
            'job ID' => $this->event->job->getJobId(),
            'Job Name' => $this->event->job->resolveName(),
            'Message Body' => $this->event->exception->getMessage(),
        ];
    }

}
