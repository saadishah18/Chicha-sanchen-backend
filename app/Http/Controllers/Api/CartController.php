<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartApiResource;
use App\Http\Resources\CartResource;
use App\Models\AddOnValue;
use App\Models\Cart;
use App\Models\CartAddOnValue;
use App\Models\CartAdOnValues;
use App\Models\CartItem;
use App\Service\Facades\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function addToCart(Request $request,$cart_id = null)
    {
        try {
            $requestData = $request->all();
            $result = DB::transaction(function () use ($requestData,$cart_id) {
                if($cart_id != null){
                    $cart = Cart::find($cart_id);
//                    dd($cart == null);
                    if($cart == null){
                      return false;
                    }
                }else{
                    $cart = Cart::create([
                        'user_id' => auth()->id(),
                    ]);
                }


                foreach ($requestData as $cartDetail) {
                    $cartItem = new CartItem([
                        'product_id' => $cartDetail['product_id'],
                        'category_id' => $cartDetail['category_id'],
                        'product_price' => $cartDetail['product_price'],
                    ]);

                    $cart->cartItems()->save($cartItem);

                    foreach ($cartDetail['add_ons'] as $addon) {
                        if (isset($addon['sub_add_ons']) && count($addon['sub_add_ons'])) {
                            foreach ($addon['sub_add_ons'] as $sub_add_on) {
                                $cartProductAddOn = $cartItem->cartProductAddOns()->create([
                                    'product_id' => $cartDetail['product_id'],
                                    'parent_add_on_id' => $addon['add_on_id'],
                                    'child_add_on_id' => $sub_add_on['add_on_id'],
                                ]);

                                foreach ($sub_add_on['values'] as $value_index => $val) {
                                    $addOnValue = AddOnValue::find($val['id']);
                                    $valueName = $addOnValue ? $addOnValue->value : ''; // Assuming 'value' is the string column in your AddOnValue model
                                    $obj = new CartAddOnValue([
                                        'cart_id' => $cart->id,
                                        'cart_item_id' => $cartItem->id,
                                        'product_id' => $cartDetail['product_id'],
                                        'add_on_id' => $val['add_on_id'],
                                        'value_name' => is_array($valueName) ? json_encode($valueName) : $valueName,
                                        'value_id' => $val['id'],
                                        'value_price' => $val['price'],
                                    ]);
                                    $obj->save();
                                }
                            }
                        } else {
                            $cartProductAddOn = $cartItem->cartProductAddOns()->create([
                                'product_id' => $cartDetail['product_id'],
                                'parent_add_on_id' => null,
                                'child_add_on_id' => $addon['add_on_id'],
                            ]);

                            foreach ($addon['values'] as $value_index => $val) {
                                $addOnValue = AddOnValue::find($val['id']);
                                $valueName = $addOnValue ? $addOnValue->value : ''; // Assuming 'value' is the string column in your AddOnValue model

                                $obj = new CartAddOnValue([
                                    'cart_id' => $cart->id,
                                    'cart_item_id' => $cartItem->id,
                                    'product_id' => $cartDetail['product_id'],
                                    'add_on_id' => $val['add_on_id'],
                                    'value_name' =>  $valueName,
                                    'value_id' => $val['id'],
                                    'value_price' => $val['price'],
                                ]);
                                $obj->save();
                            }
                        }
                    }
                }
                return $cart;
            });
            if($result != false){
                return Api::response($result, 'Product added to cart');
            }else{
                Log::error(['Cart log id' => $cart_id]);
                Log::error(['db transaction result' => $result]);
                return Api::error('Cart could not be made! Contact admin');
            }
        } catch (\Exception $exception) {
//            return Api::error($exception->getMessage());
            dd($exception->getMessage(), $exception->getLine(), $exception->getFile());
        }

    }

    public function cartDetail(Request $request)
    {
        try {
            $user = auth()->user();
            $cart = $user->cart;
// Check if the $cart exists before attempting to use it
            if ($cart) {
                return Api::response(new CartApiResource($cart), 'Cart Detail');
            } else {
                // Handle the case when the cart is not found
                // You might want to return a response or perform other actions
                return Api::error('User Cart not exists');
            }
        } catch (\Exception $exception) {
            dd($exception->getMessage(), $exception->getLine(), $exception->getFile());
            return Api::server_error($exception);
        }
    }
}
