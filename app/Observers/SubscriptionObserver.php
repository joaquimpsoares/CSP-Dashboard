<?php

namespace App\Observers;

use App\Subscription;
use App\Notifications\SubscriptionUpdate;
use Illuminate\Support\Facades\Notification;

class SubscriptionObserver
{

    /**
     * Handle the Subscription "created" event.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return void
     */
    public function creating(Subscription $subscription)
    {
    }

    /**
     * Handle the Subscription "created" event.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return void
     */
    public function created(Subscription $subscription)
    {
    }

    /**
     * Handle the Subscription "updated" event.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return void
     */
    public function updated(Subscription $subscription)
    {
        $changes = $subscription->getChanges();
        foreach ($subscription->customer->users->filter() as $key => $user) {
            Notification::send($user, new SubscriptionUpdate($subscription, $changes));
        }
    }

    /**
     * Handle the Subscription "deleted" event.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return void
     */
    public function deleted(Subscription $subscription)
    {
    }

    /**
     * Handle the Subscription "restored" event.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return void
     */
    public function restored(Subscription $subscription)
    {
    }

    /**
     * Handle the Subscription "force deleted" event.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return void
     */
    public function forceDeleted(Subscription $subscription)
    {
    }
}
