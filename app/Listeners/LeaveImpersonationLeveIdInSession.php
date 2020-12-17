<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Lab404\Impersonate\Events\LeaveImpersonation;

class LeaveImpersonationLeveIdInSession
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
    public function handle(LeaveImpersonation $event)
    {
        session()->remove('provider_id', $event->impersonated->provider_id);
        session()->remove('reseller_id', $event->impersonated->reseller_id);
        session()->remove('customer_id', $event->impersonated->customer_id);
        foreach($event->impersonated->provider->instances as $instance){
            session()->remove('instance_id', $instance->id);
        }


        session()->remove('role', $event->impersonated->roles->first()->name);
    }
}
