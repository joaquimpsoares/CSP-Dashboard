<?php

namespace App\Listeners\Logging;

use App\Events\Logging\LoggingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MSCustomerCreation
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
     * @param  LoggingEvent  $event
     * @return void
     */
    public function handle(LoggingEvent $event)
    {
        //
    }
}
