<?php

namespace App\Http\Livewire;

use App\Price;
use App\Vendor;
use App\Product;
use App\PriceList;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\DB;

class Searchstore extends Component
{
    use UserTrait;
    
    private $user = "";
    private $level = [];
    public $search = '';
    public $categories = '';
    public $priceList = "null";
    public $category;

    use WithPagination;

    public function mount($category)
    {
        $this->category = $category;
        $this->user = $this->getUser();

        $this->categories = Product::select('category')->distinct()->get();
        $this->level = $this->getUserLevel();

        switch ($this->level) {
            case 'Customer':
                $this->priceList = $this->user->customer->priceLists->first()->id;
            break;

            case 'Reseller':
                $this->instance = $this->user->reseller->provider->instances->pluck('id');

                $this->priceList = PriceList::wherein('id',$this->instance )->pluck('id')->toArray();
                // dd($this->priceList);
                // $this->priceList = $this->user->reseller->priceList->id;
            break;
            
            default:
            return abort(403, __('errors.unauthorized_action'));
        break;
        }
    }
    
    public function searchCategory($name)
    {
        $this->search = $name;
    }
    
    public function render()
    {
        return view('livewire.searchstore', 
        [

            'prices' => DB::table('prices')
            ->join('products', 'prices.product_sku', '=', 'products.sku')
            ->where('category', $this->category)
            ->having('price_list_id', $this->priceList)->where('prices.name', 'like', '%' . $this->search . '%')
            ->orwhere('product_sku', 'LIKE', "%$this->search%")->where('category', $this->category)->paginate(9),
           
            // Price::having('price_list_id', $this->priceList)->where('name', 'like', '%' . $this->search . '%')
            // ->orwhere('product_sku', 'LIKE', "%$this->search%")->where('category', $this->category)->paginate(9),
        ]);
    }
}
