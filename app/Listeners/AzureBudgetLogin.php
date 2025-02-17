<?php

namespace App\Listeners;

use DateTime;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AzureBudgetNotification;
use App\Repositories\AnalyticRepositoryInterface;

class AzureBudgetLogin
{
    /**
    * Create the event listener.
    *
    * @return void
    */
    public function __construct(AnalyticRepositoryInterface $analyticRepository)
    {
        $this->analyticRepository = $analyticRepository;
    }

    /**
    * Handle the event.
    *
    * @param  IlluminateAuthEventsLogin  $event
    * @return void
    */
    public function handle(login $event)
    {
        $fechahoy = new DateTime();
        // Session::flash('success', 'Hello ' . $event->user->name . ', welcome back!');
        $resourceName = $this->analyticRepository->getAzureSubscriptions();
        if($resourceName->total() > 0){
            $resourceName->map(function ($item, $key) {
                foreach ($item->azureresources as $resource) {
                    $increase = ($item->budget - $item->azureresources->sum('cost'));
                    if ($item->budget > '0') {
                        if ($increase !== '0') {
                            $average1 = ($increase / $item->budget) * 100;
                            $item['percentage'] = 100 - $average1;
                        } else {
                            $item['percentage'] = '0';
                        }
                        return $item;
                    }
                }
            });
            $date = $fechahoy->diff($resourceName->first()->updated_at);
            if ($resourceName->first() != null){
                if($resourceName->first()->percentage >= '90' ){
                    if($date->format('%R%a') >= 10 ){
                        Notification::send($event->user, new AzureBudgetNotification($resourceName));
                    }
                }
            }
        }
    }
}
