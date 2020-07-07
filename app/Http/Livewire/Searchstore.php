<?php

namespace App\Http\Livewire;

use App\Price;
use App\Vendor;
use App\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\UserTrait;

class Searchstore extends Component
{
    use UserTrait;
    
    private $user = "";
    private $level = [];
    public $search = '';
    public $categories = '';
    public $priceList = "null";

    use WithPagination;

    public function mount()
    {
        $this->user = $this->getUser();

        $this->categories = Product::select('category')->distinct()->get();
        $this->level = $this->getUserLevel();

        switch ($this->level) {
            case 'Customer':
                $this->priceList = $this->user->customer->priceList->id;
            break;

            case 'Reseller':
                $this->priceList = $this->user->reseller->priceList->id;
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
            
            'prices' => Price::having('price_list_id', $this->priceList)->where('name', 'like', '%' . $this->search . '%')
            ->orwhere('product_sku', 'LIKE', "%$this->search%")->paginate(9),
        ]);
    }
}
