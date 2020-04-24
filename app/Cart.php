<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $customer = null;
    public $domain = null;
    

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($product) {
        $storedItem = ['quantity' => 0, 'price' => $product->price ?? 0, 'item' => $product];

        if ($this->items) {
            if (array_key_exists($product->id, $this->items)) {
                $storedItem = $this->items[$product->id];
            }
        }

        $storedItem['quantity']++;
        //$storedItem['price'] = $product->price * $storedItem['quantity'];

        $this->items[$product->id] = $storedItem;
        $this->totalQty++;
        //$this->totalPrice += $product->price;
    }

    public function reduceByOne($id) {
        $this->items[$id]['quantity']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['price'];
        if ($this->items[$id]['quantity'] <= 0) {
            unset($this->items[$id]);
        }
    }

    public function removeItem($id) {
        $this->totalQty -= $this->items[$id]['quantity'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }

    public function addCustomer($customer) {
        $this->customer = $customer;
    }

    public function addDomain($domain) {
        $this->domain = $domain;
    }
}
