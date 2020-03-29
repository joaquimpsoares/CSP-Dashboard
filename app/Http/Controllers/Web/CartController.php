<?php

namespace App\Http\Controllers\Web;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
	public function index() {
        $cart = [];
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        return view('order.cart', ['products' => $cart]);
    }

    public function addProduct(Request $request, Product $product)
    {
    	
    	$oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product);
        ($cart->items[$product->id]['quantity']);
        $request->session()->put('cart', $cart);
        return redirect()->route('cart.index');
    }

    public function removeProduct(Request $request, Product $product)
    {
        
        $cart = Session::has('cart') ? Session::get('cart') : null;
        
        if (!empty($cart)) {
            unset($cart->items[$product->id]);
        }

        return redirect()->route('cart.index');
    }

    public function destroy()
    {
        Session::forget('cart');

        return redirect()->route('cart.index');
    }
}
