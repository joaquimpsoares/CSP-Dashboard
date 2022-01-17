<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use App\Price;
use App\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Vendor;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    use UserTrait;

	private $productRepository;

	public function __construct(ProductRepositoryInterface $productRepository)
	{
		$this->productRepository = $productRepository;

	}


    public function index(Request $request) {

        $user = $this->getUser();

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):
                return abort(403, __('errors.access_with_resellers_credentials'));

                break;
            case 'app.admin':
                return abort(403, __('errors.access_with_resellers_credentials'));
            break;

            default:
                # code...
                break;
        }
        return view('store.index');
    }

    public function categories($vendor) {

        switch ($vendor) {
            case 'microsoft':
                $categories = Product::select('category')->where('vendor', $vendor)->groupby('category')->get();
                break;
            case 'kaspersky':
                # code...
                $categories = Product::select('category')->where('vendor', $vendor)->groupby('category')->get();
                break;

            default:
            return abort(403, __('errors.unauthorized_action'));
        break;
        }

        return view('store.categories', compact('categories', 'vendor'));
    }

    public function searchstore($category,$vendor) {
        $this->category = $category;
        $this->vendor = $vendor;


        return view('store.searchstore', compact('category','vendor'));
    }
}
