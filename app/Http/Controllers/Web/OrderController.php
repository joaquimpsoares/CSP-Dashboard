<?php

namespace App\Http\Controllers\Web;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Session;

class OrderController extends Controller
{

    private $productRepository;
    

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function addProductToCart(Request $request)
    {

        $product = Product::find($request->product_id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $request->qty);
                // ($cart->items[$product->id]['qty']);

        $request->session()->put('cart', $cart);

        return redirect()->route('order.shoppingcart');
    }

    public function getCart() {
        if (!Session::has('cart')) {
            return view('store.shoppingcart');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        return view('order.cart', ['products' => $cart->items]);
    }

    public function changeProductQuantity(Request $request, Product $product, $quantity) {
        
        if ($this->productRepository->verifyQuantities($product, $quantity)) {
            $oldCart = \Session::get('cart');
            $cart = new Cart($oldCart);
            $cart->items[$product->id]['quantity'] = $quantity;
            $request->session()->put('cart', $cart);

            return true;
        }

        return false;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
