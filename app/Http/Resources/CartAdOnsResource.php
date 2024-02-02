<?php

namespace App\Http\Resources;

use App\Models\AddOn;
use App\Models\CartAddOnValue;
use App\Models\CartProductAddOns;
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
        $values = CartAddOnValue::where('cart_item_id',$this->cart_item_id)->where('add_on_id',$this->child_add_on_id)->get();
        $sub_addons = $this->parent_add_on_id != null ? CartProductAddOns::where('parent_add_on_id',$this->parent_add_on_id)
            ->where('cart_item_id',$this->cart_item_id)->get() : [];
       return [
           'cart_ad_on_id' => $this->id,
           'cart_item_id' => $this->cart_item_id,
           'product_id' => $this->product_id,
           'product_name' => $this->product->name,
           'parent_add_on_id' => $this->parent_add_on_id,
           'parent_add_on_name' => $this->parent_add_on_id != null ? AddOn::find($this->parent_add_on_id)->name : null,
           'child_add_on_id' => $this->child_add_on_id,
           'child_add_on_name' => $this->child_add_on_id != null ? AddOn::find($this->child_add_on_id)->name : null,
           'sub_add_ons' => $this->parent_add_on_id != null ?  CartSubAddOnResource::collection($sub_addons) : [],
           'values' => $this->parent_add_on_id == null ? CartAddOnValueResource::collection($values) : [],
       ];
    }
}
