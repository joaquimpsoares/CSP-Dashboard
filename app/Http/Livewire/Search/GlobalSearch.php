<?php

namespace App\Http\Livewire\Search;

use App\Customer;
use App\Provider;
use App\Reseller;
use Livewire\Component;
use Spatie\Searchable\Search;
use App\Http\Traits\UserTrait;
use Illuminate\Database\Query\Builder;

class GlobalSearch extends Component
{
    use UserTrait;

    public $keyword = "";
    public $searchproduct;

    public function updatedKeyword(){

        if(!$this->keyword){
            return $this->searchproduct = null;
        }

        switch ($this->getUserLevel()) {
            case 'Super Admin':
                $this->searchproduct = (new Search())
                ->registerModel(Customer::class, 'company_name')
                ->registerModel(Reseller::class, 'company_name')
                ->registerModel(Provider::class, 'company_name')
                ->search($this->keyword);
            break;
            case config('app.admin'):
                $this->searchproduct = (new Search())
                ->registerModel(Customer::class, 'company_name')
                ->registerModel(Reseller::class, 'company_name')
                ->search($this->keyword);
            break;
            case config('app.provider'):
                $this->searchproduct = (new Search())
                ->registerModel(Customer::class, 'company_name')
                ->registerModel(Reseller::class, 'company_name')
                ->search($this->keyword);
            break;
            case config('app.reseller'):
                $this->searchproduct = (new Search())
                ->registerModel(Customer::class, 'company_name')
                ->search($this->keyword);
            break;
            case config('app.subreseller'):
                $this->searchproduct = (new Search())
                ->registerModel(Customer::class, 'company_name')
                ->search($this->keyword);break;
            case config('app.customer'):
            break;
            default:
                # code...
            break;
                }



    }
    public function render()
    {
        return view('livewire.search.global-search');
    }
}
