<?php

namespace App\Observers;

use App\Models\Cart;

class CartObserver
{
    public function deleting(Cart $cart){
        $items =  $cart->cartItems;
        foreach ($items as $item){
            $item->delete();
        }
    }
}
