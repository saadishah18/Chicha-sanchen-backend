<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartAdOnsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
           'cart_ad_on_id' => $this->id,
           'cart_item_id' => $this->cart_item_id,
           'product_id' => $this->product_id,
           'product_name' => $this->product->name,
           'parent_add_on_id' => $this->parent_add_on_id,
           'parent_add_name' => $this->parent_add_on_id != null ? $this->parentAddOnDetail->name : null,
           'sub_add_ons' => $this->parent_add_on_id != null ? $this->subAddons() : [],
       ];
    }

    public function subAddOns(){

    }
}
