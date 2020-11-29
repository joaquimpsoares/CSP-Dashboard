<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetLeveIdInSession
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        session()->put('provider_id', $event->user->provider_id);
        session()->put('reseller_id', $event->user->reseller_id);
        session()->put('customer_id', $event->user->customer_id);

        session()->put('role', $event->user->roles->first()->name);
    }
}
