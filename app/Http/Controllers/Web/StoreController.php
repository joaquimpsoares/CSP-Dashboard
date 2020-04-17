<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepositoryInterface;
use App\Vendor;
use Illuminate\Http\Request;

class StoreController extends Controller
{

	private $quantity = 12;
	private $productRepository;

	public function __construct(ProductRepositoryInterface $productRepository) 
	{
		$this->productRepository = $productRepository;
	}


    public function index(Request $request) {
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
        
        $vendors = Vendor::orderBy('name')->get();

        $quantity = $this->quantity;

        return view('store.index', compact('products', 'vendors', 'filters', 'quantity'));
    }
}
