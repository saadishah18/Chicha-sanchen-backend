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
//        dd($this->cartProductAddOns);
        $result = [
            'cart_item_id' => $this->id,
            'product_id' => $this->product_id,
            'product_name' => $this->product->name,
            'product_image' => $this->product && $this->product->image !=null ? imagePath($this->product->image) : null,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'product_price' => $this->product_price,
            'add_ons' => CartAdOnsResource::collection($this->cartProductAddOns)
        ];
        return $result;

    }
}
