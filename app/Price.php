<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
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
        return $this->belongsTo(Product::class)->where('vendor', $this->product_vendor)->where('instance_id', session()->get('instance_id'));
    }

    public function tiers()
    {
        return $this->belongsToMany(Tier::class);
    }
}
