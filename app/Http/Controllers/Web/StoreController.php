<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use App\Price;
use App\Repositories\ProductRepositoryInterface;
use App\Vendor;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    use UserTrait;

	private $quantity = 12;
	private $productRepository;

	public function __construct(ProductRepositoryInterface $productRepository) 
	{
		$this->productRepository = $productRepository;
        
	}


    public function index(Request $request) {


        $user = $this->getUser();
        $userLevel = $this->getUserLevel();

    	$filters = $request->validate([
            'name' => 'string|nullable',
            'vendor' => 'nullable|exists:App\Vendor,name',
            'search' => 'integer|size:1',
            'page' => 'integer',
            'quantity' => 'integer'
        ]);

        if (isset($filters['quantity']) && $filters['quantity'] > 0 && $filters['quantity'] !== 12) 
            $this->quantity = $filters['quantity'];
            

        $products = $this->productRepository->all($filters, $this->quantity);

        $products = [];
        $prices = null;
        switch ($userLevel) {
            case 'Provider':
                # code...
                break;
            
            case 'Reseller':
                $priceList = $user->reseller->priceList->id;
                $prices = Price::where('price_list_id', $priceList)->paginate($this->quantity);

                foreach ($prices as $price) {
                    $products[] = $price->product;
                }


                break;
            
            default:
                # code...
                break;
        }
        
        $vendors = Vendor::orderBy('name')->get();

        $quantity = $this->quantity;

        return view('store.index');
    }
}
