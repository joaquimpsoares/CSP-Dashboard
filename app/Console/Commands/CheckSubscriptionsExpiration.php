<?php

namespace App\Console\Commands;

use DateTime;
use App\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SubscriptionAboutToExpire;

class CheckSubscriptionsExpiration extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'command:checkSubscriptionExpiration';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Command description';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle()
    {
        $fechahoy = new DateTime();
        $subscriptions = Subscription::get();
        foreach ($subscriptions as $key => $subscription) {
            foreach ($subscription->customer->users as $key => $user) {
                $deate = new DateTime($subscription->expiration_data);
                $interval = $fechahoy->diff($deate);
                if ($interval->format('%R%a') <= 90){
                    Notification::send($user, new SubscriptionAboutToExpire($subscription, $interval->format('%R%a')));
                    $user->update(['notified' => true]);
                    Log::debug($user->email.' notified');
                }
            }
        }
        Mail::raw("Just finished Checking for subscriptions to send alert", function ($mail)  {
            $mail->to('joaquim.soares@tagydes.com')
            ->subject('Monthly notify customers subscription about to expire');
        });
        $this->info('Successfully sent daily quote to everyone.');
    }
}

