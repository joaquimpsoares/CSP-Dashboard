<?php

namespace App\Http\Livewire\Price;

use App\Tier;
use App\Price;
use App\Product;
use App\PriceList;
use Livewire\Component;

class Editprice extends Component
{

    public $price, $name, $tier_product_sku,
    $tier_price, $currency, $tier_min_quantity, $tier_name,
    $tier_max_quantity, $tier_msrp, $priceList;

    public $product_sku, $min_quantity, $max_quantity, $msrp, $priceU, $selected_id;

    public $updateMode = false;

    private function resetInput()
    {
        $this->name = null;
        $this->msrp = null;
        $this->priceU = null;
        $this->product_sku = null;
        $this->min_quantity = null;
        $this->max_quantity = null;
    }

    public function addpriceTier()
    {

        $tier = new Tier();
        $tier->name            = $this->name;
        $tier->product_sku     = $this->product_sku;
        $tier->min_quantity    = $this->min_quantity;
        $tier->max_quantity    = $this->max_quantity;
        $tier->price           = $this->price;
        $tier->msrp            = $this->msrp;

        $tier->save();

        $tier->prices()->attach($this->price);

        $this->resetInput();

    }

    public function update()
    {

        $this->validate([
            // 'id' => 'exists:App\Tier,id',
            'name' => 'required|string',
            'product_sku' => 'required|string',
            'min_quantity' => 'required|numeric',
            'max_quantity' => 'required|numeric',
            'price' => 'required',
            'msrp' => 'required',
        ]);


        if ($this->selected_id) {
            $record = Tier::find($this->selected_id);
            $record->update([
                'name'            => $this->name,
                'product_sku'     => $this->product_sku,
                'min_quantity'    => $this->min_quantity,
                'max_quantity'    => $this->max_quantity,
                'price'           => $this->priceU,
                'msrp'            => $this->msrp,
            ]);

            $this->resetInput();

            $this->updateMode = false;

        }

    }

    public function removepriceTier($id)
    {
        if ($id) {

            $record = Tier::where('id', $id)->first();

            $record->prices()->detach($this->price);

            $record->delete();
        }
    }
        public function edit($id)
    {
        $record = Tier::findOrFail($id);

        $this->selected_id = $id;
        $this->name = $record->name;
        $this->product_sku = $record->product_sku;
        $this->min_quantity = $record->min_quantity;
        $this->max_quantity = $record->max_quantity;
        $this->priceU = $record->price;
        $this->msrp = $record->msrp;
        $this->updateMode = true;
    }


    public function mount($price)
    {
        $this->price = $price;

    }


    public function render()
    {

        $this->price = Price::where('id', $this->price->id)->first();
        return view('livewire.price.editprice', [
        ]);
    }

}
