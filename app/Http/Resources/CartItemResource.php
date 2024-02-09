<?php

namespace App\Http\Resources;

use App\Models\AddOn;
use App\Models\AddOnValue;
use App\Models\CartProductAddOns;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product_item_price = $this->calculateTotalPrice();

        $result = [
            'cart_item_id' => $this->id,
            'product_id' => $this->product_id,
            'product_name' => $this->product->name,
            'product_item_price' => $product_item_price,
            'product_image' => $this->product && $this->product->image !=null ? imagePath($this->product->image) : null,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'product_price' => $this->product_price,
            'add_ons' => CartAdOnsResource::collection($this->cartProductAddOns->unique('parent_add_on_id'))
        ];
        return $result;

    }


    private function calculateTotalPrice()
    {
        $totalPrice = $this->product_price;

        // Calculate total price from cart items
        foreach ($this->cartAddOnValues as $cartProductAddOn) {
//                foreach ($cartProductAddOn->cartAdOnValues as $cartAdOnValue) {
//                    $totalPrice += $cartAdOnValue->value_price;
            $totalPrice += $cartProductAddOn->value_price;
//                }
        }
        return $totalPrice;
    }
}
