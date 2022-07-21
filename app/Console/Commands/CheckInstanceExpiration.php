<?php

namespace App\Console\Commands;

use DateTime;
use App\Instance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Notifications\InstanceAboutToExpire;
use Illuminate\Support\Facades\Notification;

class CheckInstanceExpiration extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'command:CheckInstanceExpiration';

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
        $instances = Instance::get();
        foreach ($instances as $key => $instance) {

            if(isset($instance->external_token_updated_at)){
                $expiration = $instance->external_token_updated_at->addDays(90);
                foreach ($instance->provider->users->where('name', 'Provider') as $key => $user) {
                    $date = new DateTime($expiration);
                    $interval = $fechahoy->diff($date);
                    if ($interval->format('%R%a') <= 90){
                        Notification::send($user, new InstanceAboutToExpire($instance, $interval->format('%R%a')));
                        Log::debug($user->email.' notified');
                    }
                }
            }
        }
        Mail::raw("Just finished Checking for instances to send alert", function ($mail)  {
            $mail->to('joaquim.soares@tagydes.com')
            ->subject('Monthly notify Providers instance is about to expire');
        });
        $this->info('Successfully sent daily quote to everyone.');
    }
}

