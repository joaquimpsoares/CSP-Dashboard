<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Price;
use App\PriceList;

class PriceChanged
{
    use Dispatchable, SerializesModels;

    public Price $price;
    public PriceList $priceList;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Price $price)
    {
        $this->price = $price;
        $this->priceList = $price->pricelist;
    }
}
