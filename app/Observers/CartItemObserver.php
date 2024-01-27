<?php

namespace App\Observers;

use App\Models\CartItem;

class CartItemObserver
{
    public function deleting(CartItem $item){
       $cart_add_ons =  $item->cartProductAddOns;
       foreach ($cart_add_ons as $add_on){
           $add_on->delete();
       }
       $values = $item->cartAddOnValues;
       foreach ($values as $value){
           $value->delete();
       }
    }
}
