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
        // IMPORTANT: Always continue the request for guests.
        if (Auth::check()) {
            $user = Auth::user();
            $fechahoy = new DateTime();

            switch ($this->getUserLevel()) {
                case config('app.customer'):
                    $updated_at = new DateTime($user->updated_at);
                    $date = $fechahoy->diff($updated_at);

                    if ($date->format('%R%a') >= 30) {
                        foreach ($user->customer->subscriptions as $subscription) {
                            $deate = new DateTime($subscription->expiration_data);
                            $interval = $fechahoy->diff($deate);

                            if ($interval->format('%R%a') <= 90) {
                                Notification::send($user, new SubscriptionAboutToExpire($subscription, $interval->format('%R%a')));
                                $user->update(['notified' => true]);
                            }
                        }
                    }
                    break;

                default:
                    break;
            }
        }

        return $next($request);
    }
}

