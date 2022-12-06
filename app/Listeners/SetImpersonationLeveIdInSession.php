<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Lab404\Impersonate\Events\TakeImpersonation;

class SetImpersonationLeveIdInSession
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
    public function handle(TakeImpersonation $event)
    {

        if($event->impersonated->roles->first()->name == 'Provider'){
            session()->put('provider_id', $event->impersonated->provider_id);
            foreach($event->impersonated->provider->instances as $instance)
            {
                session()->put([
                    'instance_id' => $instance->id,
                    'instance_type' => $instance->type
                ]);
            }
        }elseif($event->impersonated->roles->first()->name == 'Reseller'){
            session()->put('reseller_id', $event->impersonated->reseller_id);
            foreach($event->impersonated->reseller->provider->instances as $instance){
                session()->put([
                    'instance_id' => $instance->id,
                    'instance_type' => $instance->type
                ]);
            }
        }elseif($event->impersonated->roles->first()->name == 'Customer'){
            session()->put('customer_id', $event->impersonated->customer_id);
            foreach($event->impersonated->customer->resellers->first()->provider->instances as $instance){
                session()->put([
                    'instance_id' => $instance->id,
                    'instance_type' => $instance->type
                ]);
            }
        }
        session()->put('role', $event->impersonated->roles->first()->name);
    }
}
