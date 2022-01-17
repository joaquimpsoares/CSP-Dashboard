<?php

namespace App\Console\Commands;

use DateTime;
use Carbon\Carbon;
use App\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class RenewSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RenewSubscriptions';

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
                if ($interval->format('%R%a') <= 1 && $subscription->autorenew === true){
                    $newDateTime = Carbon::now()->addYears(1);
                    $subscription->update([
                        'expiration_data' => $newDateTime,
                    ] + $subscription->changes_on_renew);
                    // Notification::send($user, new SubscriptionAboutToExpire($subscription, $interval->format('%R%a')));
                    // $user->update(['notified' => true]);
                    Log::debug('Subscription id: '.$subscription->id .' has renewed');
                }
            }
        }
        Mail::raw("Just finished renewing subscriptions", function ($mail)  {
            $mail->to('joaquim.soares@tagydes.com')
            ->subject('Monthly renewing customers subscription that have expired');
        });
        $this->info('Successfully sent daily quote to everyone.');
    }
}
