<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartApiResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Service\Facades\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $requestData = $request->all();
        $result = DB::transaction(function () use ($requestData) {
            $cart = Cart::create([
                'user_id' => auth()->id()
            ]);
            foreach ($requestData as $cartDetail) {
                $cartItem = new CartItem([
                    'product_id' => $cartDetail['product_id'],
                    'category_id' => $cartDetail['category_id'],
                    'product_price' => $cartDetail['product_price'],
                ]);

                $cart->cartItems()->save($cartItem);
                // If there are addons
                foreach ($cartDetail['add_ons'] as $addon) {
                    if (isset($addon['sub_add_ons']) && count($addon['sub_add_ons'])) {
                        foreach ($addon['sub_add_ons'] as $sub_ad_on_index => $sub_add_on) {
                            foreach ($sub_add_on['values'] as $value_index => $val) {
                                $cartItem->cartProductAddOns()->create(
                                    [
                                        'product_id' => $cartDetail['product_id'],
                                        'parent_add_on_id' => $addon['add_on_id'],
                                        'child_add_on_id' => $sub_add_on['add_on_id'],
                                        'add_on_value_id' => $val['id'],
                                        'add_value_price' => $val['price'],
                                    ]
                                );
                            }
                        }
                    } else {
                        foreach ($addon['values'] as $value_index => $val) {
                            $cartItem->cartProductAddOns()->create([
                                'product_id' => $cartDetail['product_id'],
                                'parent_add_on_id' => null,
                                'child_add_on_id' => $addon['add_on_id'],
                                'add_on_value_id' => $val['id'],
                                'add_value_price' => $val['price'],
                            ]);
                        }
                    }
                }
            }
            return $cart;
        });
        return Api::response($result->refresh(), 'Product added to cart');
    }

    public function cartDetail(Request $request){
        try {
            $user = auth()->user();
            $cart = $user->cart;
// Check if the $cart exists before attempting to use it
            if ($cart) {
                return Api::response(new CartApiResource($cart),'Cart Detail');
            } else {
                // Handle the case when the cart is not found
                // You might want to return a response or perform other actions
                dd('Cart not found for the user.');
            }
        }catch (\Exception $exception){
            dd($exception->getMessage(),$exception->getLine(),$exception->getFile());
            return Api::server_error($exception);
        }
    }
}
