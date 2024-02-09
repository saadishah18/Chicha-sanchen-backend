<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request,$type = null): array
    {
        $path = ltrim(request()->path(), '/');
        $lastSegment = basename($path);//        return parent::toArray($request);

        if($lastSegment == 'cart-detail'){
            $items = $this->cartItems;

        }else{
            $items = $this->cartItems()->latest()->first();
        }
        $totalPrice = $this->calculateTotalPrice();

        return [
            'cart_id' => $this->id,
            'user_id' => $this->user_id,
            'total_price' => $totalPrice,
            'cart_items' => $items instanceof \Illuminate\Database\Eloquent\Model
                ? [new CartItemResource($items)]
                : CartItemResource::collection($items)
        ];
    }

    private function calculateTotalPrice()
    {
        $totalPrice = 0;
        // Calculate total price from cart items
        foreach ($this->cartItems as $cartItem) {
            $totalPrice += $cartItem->product_price;

            // Calculate total price from add-on values
            foreach ($cartItem->cartAddOnValues as $cartProductAddOn) {
//                foreach ($cartProductAddOn->cartAdOnValues as $cartAdOnValue) {
//                    $totalPrice += $cartAdOnValue->value_price;
                    $totalPrice += $cartProductAddOn->value_price;
//                }
            }
        }

        return $totalPrice;
    }
}
