<?php

namespace App;

use App\Events\PriceChanged;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    // protected $dispatchesEvents = [
    //     'saved' => PriceChanged::class
    // ];

    public function format()
    {
        return [
            'id' => $this->id,
            'product_sku' => $this->product_sku,
            'product_vendor' => $this->product_vendor,
            'price_list_id' => $this->price_list_id,
            'name' => $this->name,
            'price' => $this->price,
            'msrp' => $this->msrp,
            'currency' => $this->currency,
            'pricelist' => $this->pricelist,
            'instance' => $this->pricelist->id,
            'category' => $this->product,
        ];
    }

    public function pricelist()
    {
        return $this->belongsTo(PriceList::class, 'price_list_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function related_product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function tiers()
    {
        return $this->belongsToMany(Tier::class);
    }
}
