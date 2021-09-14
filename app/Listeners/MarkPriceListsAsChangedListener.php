<?php

namespace App\Listeners;

use App\PriceList;
use App\Reseller;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\InteractsWithQueue;

class MarkPriceListsAsChangedListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $parentPriceList = $event->priceList;

        // We aren't using touch() here because we want a mass update (performance)
        PriceList::whereHas('reseller', function(Builder $query) use (&$parentPriceList){
            $query->where('price_list_id', $parentPriceList->id);
        })->update(['updated_at' => now()]);
    }
}
