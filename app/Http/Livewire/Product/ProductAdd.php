<?php

namespace App\Http\Livewire\Product;

use App\Status;
use App\Product;
use Livewire\Component;
use App\Models\Product as ModelsProduct;

class ProductAdd extends Component
{
    public Product $product;

    public function rules()
    {
        return [
            'prodcut.name'                      => 'required'|'string'|'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/'|'max:255',
            'prodcut.description'               => 'required'|'min:3',
            'prodcut.vendor'                    => 'required'|'integer'|'min:1',
            'prodcut.sku'                       => 'required'|'string'|'max:255'|'min:3',
            'prodcut.catalog_item_id'           => 'nullable'|'string'|'max:255'|'min:3',
            'prodcut.vendor'                    => 'required'|'string'|'max:255'|'min:3',
            'prodcut.productType'               => 'required'|'string'|'max:255'|'min:3',
            'prodcut.minimum_quantity'          => 'required'|'string'|'max:255'|'min:3',
            'prodcut.maximum_quantity'          => 'required'|'integer'|'exists:statuses,id',
            'prodcut.limit'                     => 'nullable'|'integer'|'min:3',
            'prodcut.term'                      => 'required'|'integer'|'exists:price_list,id',
            'prodcut.supported_billing_cycles'  => 'required'|'integer'|'exists:price_list,id',
            'prodcut.terms'                     => 'required'|'integer'|'exists:price_list,id',
            'prodcut.resellee_qualifications'   => 'required'|'integer'|'exists:price_list,id',
            'is_available_for_purchase'         => 'required',
        ];
    }

    public function render()
    {

        return view('livewire.product.product-add')->extends('layouts.master');
    }
}
