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
        if($event->user->roles->first()->name == 'Provider'){
            session()->put('provider_id', $event->user->provider_id);
            foreach($event->user->provider->instances as $instance){
                session()->put([
                    'instance_id' =>$instance->id,
                    'instance_type' => $instance->type]);
            }
            }elseif($event->user->roles->first()->name == 'Reseller'){
                session()->put('reseller_id', $event->user->reseller_id);
                foreach($event->user->reseller->provider->instances as $instance){
                    session()->put([
                        'instance_id' => $instance->id,
                        'instance_type' => $instance->type]);
            }
            }elseif($event->user->roles->first()->name == 'Customer'){
                session()->put('customer_id', $event->user->customer_id);
                foreach($event->user->customer->resellers->first()->provider->instances as $instance){
                    session()->put([
                        'instance_id' => $instance->id,
                        'instance_type' => $instance->type]);
            }
        }
    session()->put('role', $event->user->roles->first()->name);
    }
}
