<?php

namespace App\Http\Resources;

use App\Models\CartAddOnValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartSubAddOnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $values = CartAddOnValue::where('cart_item_id',$this->cart_item_id)->where('add_on_id',$this->child_add_on_id)->get();

        return [
            'parent_add_on_id' => $this->parent_add_on_id,
            'add_on_id' => $this->child_add_on_id,
            'child_add_on_id' => $this->child_add_on_id,
            'values' => CartAddOnValueResource::collection($values),
        ];
    }
}
