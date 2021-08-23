<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SubscriptionAboutToExpire;

class Subscribed
{
    use UserTrait;
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            $user = Auth::user();
            $fechahoy = new DateTime();

            switch ($this->getUserLevel()) {
                case config('app.customer'):
                    if($user->notified == false ){
                    foreach ($user->customer->subscriptions as $subscription) {
                        $deate = new DateTime($subscription->expiration_data);
                        $interval = $fechahoy->diff($deate);
                        if ($interval->format('%R%a') <= 233){
                            Notification::send($user, new SubscriptionAboutToExpire($subscription, $interval->format('%R%a')));
                            $user->notified=true;
                            $user->save();
                        }
                    }
                }
                break;

                default:
            }
        }
        return $next($request);
    }
}
