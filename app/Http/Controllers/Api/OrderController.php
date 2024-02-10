<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderApiResource;
use App\Http\Resources\PaginationResource;
use App\Models\AddOnValue;
use App\Models\Cart;
use App\Models\CartAddOnValue;
use App\Models\CartProductAddOns;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemAddOnValue;
use App\Models\Product;
use App\Service\Facades\Api;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function placeOrderOld(Request $request){
        try {
            $requestData = $request->all();
//            dd($requestData);
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
//                            dd($orderDetail,'here');
                            $orderItemAddOn = $orderItem->orderItemAddOns()->create([
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
            dd($exception->getMessage(),$exception->getLine(),$exception->getFile(),$exception->getTrace());
        }

    }

    public function placeOrder(Request $request){
        try {
            $requestData = $request->all();
            $get_cart_detail = Cart::find($requestData['cart_id']);
            $cart_items = $get_cart_detail->cartItems;
            $result = DB::transaction(function () use ($requestData, $cart_items) {
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'price' => $requestData['total_price'],
                    'order_date' => now()->toDateString(),
                    'payment_status' => 'Pending',
                    'order_type' => $requestData['order_type'],
                    'order_unique_id' => generateUniqueOrderId(),
                ]);
                foreach ($cart_items as $item_index => $item) {
                    $product = Product::find($item['product_id']);
                    $category = Category::find($item['category_id']);
                    $orderItem = new OrderItem([
//                        'order_id' => $orderDetail['order_id'],
                        'product_id' => $item['product_id'],
                        'product_name' => $product->name,
                        'category_id' => $item['category_id'],
                        'category_name' => $category->name,
                        'product_price' => $item['product_price'],
                    ]);
                    $order->orderItems()->save($orderItem);
                    foreach ($item['cartProductAddOns'] as $addon) {
                        $sub_add_ons = CartProductAddOns::where('cart_item_id', $item->id)->where('parent_add_on_id', $addon->parent_add_on_id)->distinct('parent_add_on_id')->get();
                        if (count($sub_add_ons)) {
                            foreach ($sub_add_ons as $sub_add_on) {
                                $values = CartAddOnValue::where('cart_item_id', $item->id)->where('add_on_id', $sub_add_on->child_add_on_id)->get();
                                $orderItemAddOn = $orderItem->orderItemAddOns()->create([
                                    'order_id' => $order->id,
                                    'product_id' => $item['product_id'],
                                    'parent_add_on_id' => $addon['parent_add_on_id'],
                                    'child_add_on_id' => $sub_add_on['child_add_on_id'],
                                ]);
                                foreach ($values as $value_index => $val) {
                                    $addOnValue = AddOnValue::find($val['id']);
                                    $valueName = $addOnValue ? $addOnValue->value : ''; // Assuming 'value' is the string column in your AddOnValue model
                                    $obj = new OrderItemAddOnValue([
                                        'order_id' => $order->id,
                                        'order_item_id' => $orderItem->id,
                                        'order_item_add_ons_id' => $orderItemAddOn->id,
                                        'product_id' => $item['product_id'],
                                        'add_on_id' => $val['add_on_id'],
                                        'value_name' => $valueName,
                                        'value_id' => $val['id'],
                                        'value_price' => $val['value_price'],
                                    ]);
                                    $obj->save();
                                }
                            }
                        } else {
                            $orderItemAddOn = $orderItem->orderItemAddOns()->create([
                                'order_id' => $order->id,
                                'product_id' => $item['product_id'],
                                'parent_add_on_id' => null,
                                'child_add_on_id' => $addon['child_add_on_id'],
                            ]);

                            foreach ($addon['values'] as $value_index => $val) {
                                $addOnValue = AddOnValue::find($val['id']);
                                $valueName = $addOnValue ? $addOnValue->value : ''; // Assuming 'value' is the string column in your AddOnValue model

                                $obj = new OrderItemAddOnValue([
                                    'order_id' => $order->id,
                                    'order_item_id' => $orderItem->id,
                                    'order_item_add_ons_id' => $orderItemAddOn->id,
                                    'product_id' => $item['product_id'],
                                    'add_on_id' => $val['add_on_id'],
                                    'value_name' => $valueName,
                                    'value_id' => $val['id'],
                                    'value_price' => $val['value_price'],
                                ]);
                                $obj->save();
                            }
                        }
                    }
                }
                return $order;
            });
            if ($result != false) {
                $user = auth()->user();
                $cart = Cart::where('user_id', $user->id)->first();
                if($cart)
                    $cart->delete();
                return Api::response(new OrderApiResource($result), 'Order Created');
            } else {
                return Api::error('Cart could not be made! Contact admin');
            }
        }catch (\Exception $exception){
            dd($exception->getMessage(),$exception->getLine(),$exception->getFile(),$exception->getTrace());
        }

    }
    public function reOrder($id){
        try {
            $old_order = Order::find($id);
            $result = DB::transaction(function () use ($old_order) {
                $newOrder = $old_order->replicate();
                $newOrder->order_date = Carbon::now();
                $newOrder->created_at = Carbon::now();
                $newOrder->updated_at = Carbon::now();
                $newOrder->order_unique_id = generateUniqueOrderId();

                $newOrder->save();
                foreach ($old_order->orderItems as $item_index => $item) {
                    $newOrderItem = $item->replicate();
                    $newOrderItem->order_id = $newOrder->id; // Set the foreign key to the new order
                    $newOrderItem->save(); // Save the new order item
//                    $order->orderItems()->save($orderItem);
                    foreach ($item->orderItemAddOns as $addon) {
                        $newAddOn = $addon->replicate();
                        $newAddOn->order_id = $newOrder->id; // Set the foreign key to the new order item
                        $newAddOn->order_item_id = $newOrderItem->id; // Set the foreign key to the new order item
                        $newAddOn->save(); // Save the new add-on
                        foreach ($addon->values as $value) {
                            $newValue = $value->replicate();
                            $newValue->order_id = $newOrder->id; // Set the foreign key to the new order item
                            $newValue->order_item_id = $newOrderItem->id; // Set the foreign key to the new order item
                            $newValue->order_item_add_ons_id = $newAddOn->id; // Set the foreign key to the new order item
//                            dd($newAddOn, $newValue);

                            $newValue->save(); // Save the new add-on
                        }
                    }
                }
                return $newOrder;
            });
            if ($result != false) {
                return Api::response(new OrderApiResource($result), 'Order Created');
            } else {
                return Api::error('Cart could not be made! Contact admin');
            }
        }catch (\Exception $exception){
            dd($exception->getMessage(),$exception->getLine(),$exception->getFile(),$exception->getTrace());
        }

    }

    public function orderHistory(){
        try {
            $user = auth()->user();
            $orders = $user->orders()->paginate(5);


            // Check if the $cart exists before attempting to use it
            if (!$orders->isEmpty()) {
                return Api::response(['orders' => OrderApiResource::collection($orders),
                    'pagination' => new PaginationResource($orders)], 'Orders history');
            } else {
                // Handle the case when the cart is not found
                // You might want to return a response or perform other actions
                return Api::error('User Cart not exists');
            }
        }catch (\Exception $exception){
            return Api::server_error($exception);
        }
    }

}
