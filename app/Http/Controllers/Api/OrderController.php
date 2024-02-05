<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderApiResource;
use App\Models\AddOnValue;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemAddOnValue;
use App\Models\Product;
use App\Service\Facades\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function placeOrder(Request $request){
        try {
            $requestData = $request->all();
            $result = DB::transaction(function () use ($requestData) {
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'price' => $requestData['total_prcie'],
                    'order_date' => now()->toDateString(),
                    'payment_status' => 'Pending',
                ]);

                foreach ($requestData['items'] as $orderDetail) {
                    $product = Product::find($orderDetail['product_id']);
                    $category = Category::find($orderDetail['category_id']);
                    $orderItem = new OrderItem([
//                        'order_id' => $orderDetail['order_id'],
                        'product_id' => $orderDetail['product_id'],
                        'product_name' => $product->name,
                        'category_id' => $orderDetail['category_id'],
                        'category_name' => $category->name,
                        'product_price' => $orderDetail['product_price'],
                    ]);

                    $order->orderItems()->save($orderItem);

                    foreach ($orderDetail['add_ons'] as $addon) {
                        if (isset($addon['sub_add_ons']) && count($addon['sub_add_ons'])) {
                            foreach ($addon['sub_add_ons'] as $sub_add_on) {
                                $orderItemAddOn = $orderItem->orderItemAddOns()->create([
                                    'order_id' => $order->id,
                                    'product_id' => $orderDetail['product_id'],
                                    'parent_add_on_id' => $addon['add_on_id'],
                                    'child_add_on_id' => $sub_add_on['add_on_id'],
                                ]);

                                foreach ($sub_add_on['values'] as $value_index => $val) {
                                    $addOnValue = AddOnValue::find($val['id']);
                                    $valueName = $addOnValue ? $addOnValue->value : ''; // Assuming 'value' is the string column in your AddOnValue model
                                    $obj = new OrderItemAddOnValue([
                                        'order_id' => $order->id,
                                        'order_item_id' => $orderItem->id,
                                        'order_item_add_ons_id' => $orderItemAddOn->id,
                                        'product_id' => $orderDetail['product_id'],
                                        'add_on_id' => $val['add_on_id'],
                                        'value_name' =>  $valueName,
                                        'value_id' => $val['id'],
                                        'value_price' => $val['price'],
                                    ]);
                                    $obj->save();
                                }
                            }
                        } else {
                            $orderItemAddOn = $orderItem->cartProductAddOns()->create([
                                'order_id' => $order->id,
                                'product_id' => $orderDetail['product_id'],
                                'parent_add_on_id' => null,
                                'child_add_on_id' => $addon['add_on_id'],
                            ]);

                            foreach ($addon['values'] as $value_index => $val) {
                                $addOnValue = AddOnValue::find($val['id']);
                                $valueName = $addOnValue ? $addOnValue->value : ''; // Assuming 'value' is the string column in your AddOnValue model

                                $obj = new OrderItemAddOnValue([
                                    'order_id' => $order->id,
                                    'order_item_id' => $orderItem->id,
                                    'order_item_add_ons_id' => $orderItemAddOn->id,
                                    'product_id' => $orderDetail['product_id'],
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
                return $order;
            });
            if ($result != false) {
                // Set up the Stripe API key
                Stripe::setApiKey(config('services.stripe.secret'));
//                $paymentIntent = $result->createSetupIntent(['payment_method_types' => ['card']]);

                // Calculate the total amount including system fees (3%)
//                $systemFeePercentage = 3;
//                $systemFees = ($coffeeAmount * $systemFeePercentage) / 100;
//                $totalAmount = $coffeeAmount + $systemFees;

                // Determine the currency (assuming AED for this example)
                $currency = 'AED';

                // Create a PaymentIntent with the specified amount, currency, and payment method types

                $totalAmount = $result->price;
                $paymentIntent = PaymentIntent::create([
                    'amount' => $totalAmount * 100, // Amount is in cents
                    'currency' => $currency,
                    'payment_method_types' => ['card'],
                ]);


                return Api::response(['order' => new OrderApiResource($result),'payment_intent' => $paymentIntent], 'Order Created');
            } else {
                return Api::error('Order could not be made! Contact admin');
            }
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }

    }
    public function orderHistory(){
        try {
            $user = auth()->user();
            $orders = $user->orders;

            // Check if the $cart exists before attempting to use it
            if (!$orders->isEmpty()) {
                return Api::response(OrderApiResource::collection($orders), 'Orders history');
            } else {
                // Handle the case when the cart is not found
                // You might want to return a response or perform other actions
                return Api::error('User Cart not exists');
            }
        }catch (\Exception $exception){
            return Api::server_error($exception);
        }
    }

    public function reOrder($id){
        try {
            $requestData = $request->all();
            $result = DB::transaction(function () use ($requestData) {
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'price' => $requestData['total_prcie'],
                    'order_date' => now()->toDateString(),
                    'payment_status' => 'Pending',
                ]);


                foreach ($requestData['items'] as $orderDetail) {
                    $product = Product::find($orderDetail['product_id']);
                    $category = Category::find($orderDetail['category_id']);
                    $orderItem = new OrderItem([
//                        'order_id' => $orderDetail['order_id'],
                        'product_id' => $orderDetail['product_id'],
                        'product_name' => $product->name,
                        'category_id' => $orderDetail['category_id'],
                        'category_name' => $category->name,
                        'product_price' => $orderDetail['product_price'],
                    ]);

                    $order->orderItems()->save($orderItem);

                    foreach ($orderDetail['add_ons'] as $addon) {
                        if (isset($addon['sub_add_ons']) && count($addon['sub_add_ons'])) {
                            foreach ($addon['sub_add_ons'] as $sub_add_on) {
                                $orderItemAddOn = $orderItem->orderItemAddOns()->create([
                                    'order_id' => $order->id,
                                    'product_id' => $orderDetail['product_id'],
                                    'parent_add_on_id' => $addon['add_on_id'],
                                    'child_add_on_id' => $sub_add_on['add_on_id'],
                                ]);

                                foreach ($sub_add_on['values'] as $value_index => $val) {
                                    $addOnValue = AddOnValue::find($val['id']);
                                    $valueName = $addOnValue ? $addOnValue->value : ''; // Assuming 'value' is the string column in your AddOnValue model
                                    $obj = new OrderItemAddOnValue([
                                        'order_id' => $order->id,
                                        'order_item_id' => $orderItem->id,
                                        'order_item_add_ons_id' => $orderItemAddOn->id,
                                        'product_id' => $orderDetail['product_id'],
                                        'add_on_id' => $val['add_on_id'],
                                        'value_name' =>  $valueName,
                                        'value_id' => $val['id'],
                                        'value_price' => $val['price'],
                                    ]);
                                    $obj->save();
                                }
                            }
                        } else {
                            $orderItemAddOn = $orderItem->cartProductAddOns()->create([
                                'order_id' => $order->id,
                                'product_id' => $orderDetail['product_id'],
                                'parent_add_on_id' => null,
                                'child_add_on_id' => $addon['add_on_id'],
                            ]);

                            foreach ($addon['values'] as $value_index => $val) {
                                $addOnValue = AddOnValue::find($val['id']);
                                $valueName = $addOnValue ? $addOnValue->value : ''; // Assuming 'value' is the string column in your AddOnValue model

                                $obj = new OrderItemAddOnValue([
                                    'order_id' => $order->id,
                                    'order_item_id' => $orderItem->id,
                                    'order_item_add_ons_id' => $orderItemAddOn->id,
                                    'product_id' => $orderDetail['product_id'],
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
                return $order;
            });
            if ($result != false) {
                return Api::response(new OrderApiResource($result), 'Order Created');
            } else {
                return Api::error('Cart could not be made! Contact admin');
            }
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }

    }
}
