<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\MSCustomerCreationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MSCustomerCreationListener
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
     * @param  MSCustomerCreationEvent  $event
     * @return void
     */
    public function handle(MSCustomerCreationEvent $event)
    {

        Log::info($event->order);
    }
}
