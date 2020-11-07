<?php

namespace App\Http\Livewire\Price;

use App\Tier;
use App\Price;
use App\Product;
use App\PriceList;
use Livewire\Component;

class Addprice extends Component
{
    public $name, $product_vendor, $product_sku, 
    $price, $currency, $min_quantity, $tier_name, 
    $max_quantity, $msrp, $priceList, $products;

    public $tier_product_sku, $tier_min_quantity, $tier_max_quantity, $tier_price, $tier_msrp;


    public $prices = "";

    public function mount($priceList)
    {

        // $this->pricelist = $pricelist;

        $this->priceList = $priceList;

        $this->prices = Price::where('price_list_id', $this->priceList->id)->get();

        $this->products = Product::get();

        // dd($this->products);


        // dd($this->priceList->instance_id);
    }

    public function addPrice()
    {
        // dd('this');

        // $validatedData = $this->validate([
        //     'product_sku' => 'required|max:255',
        //     'price' => 'required',
        //     'msrp' => 'required|numeric',
        //     'product_vendor' => 'required',
        //     'currency' => 'required',
        //     ]);

        $this->pricelist = PriceList::find($this->priceList->id);

dd($this->products);

        $this->product = Product::where('sku', $this->product_sku)->where('instance_id',$this->pricelist->instance_id)->first();

// dd($this->product);

        $price = new Price();
        $price->name            = $this->product->name;
        $price->price           = $this->price;
        $price->msrp            = $this->msrp;
        $price->product_vendor  = $this->product_vendor;
        $price->currency        = $this->currency;
        $price->product_sku     = $this->product_sku;

        $price->instance_id     = $this->priceList->instance_id;

        $price->price_list_id   = $this->priceList->id;

        $price->save();

    }

    public function addpriceTier()
    {
        dd($this->price);

        $tier = new Tier();
        $tier->name            = $this->tier_name;
        $tier->product_sku     = $this->tier_product_sku;
        $tier->min_quantity    = $this->tier_min_quantity;
        $tier->max_quantity    = $this->tier_max_quantity;
        $tier->price           = $this->tier_price;
        $tier->msrp            = $this->tier_msrp;
        
        $tier->save();        
        
        $tier->prices()->attach($this->price);
        
        $this->resetInput();
    
    }

    // public function addpriceTier()
    // {
     
    //     $this->pricelist = PriceList::find($this->priceList->id);

    //     $this->product = Product::where('sku', $this->product_sku)->where('instance_id',$this->pricelist->instance_id)->first();
        
    //     $tier = new Tier();
    //     $tier->name            = $this->product->name;
    //     $tier->product_sku     = $this->tier_product_sku;
    //     $tier->min_quantity    = $this->tier_min_quantity;
    //     $tier->max_quantity    = $this->tier_max_quantity;
    //     $tier->price           = $this->tier_price;
    //     $tier->msrp            = $this->tier_msrp;
        
    //     $tier->save();
        
        
    //     // $hl = $price->tiers()->attach($tier);
        

    //     dd($tier);
        



    // }

    public function destroy($id)
        {
            if ($id) {
                $record = Tier::where('id', $id);
                $record->delete();
            }
        }

    public function render()
    {


        return view('livewire.price.addprice',[
            'products' => Product::where('instance_id', $this->priceList->instance_id)->get(),
            // 'priceLists' => $this->priceListRepository->all(), 
            'prices' => Price::get(),
        ]);
    }
}
   // Price::create([
        //     'product_sku' => $this->product_sku,
        //     'price' => $this->price,
        //     'msrp' => $this->msrp
        //     ]);

        // Tier::create([
        //     'name' => $this->name,
        //     'max_quantity' => $this->max_quantity,
        //     'min_quantity' => $this->min_quantity,
        //     ]);