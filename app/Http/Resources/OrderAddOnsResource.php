<?php

namespace App\Http\Resources;

use App\Models\AddOn;
use App\Models\CartAddOnValue;
use App\Models\OrderItemAddOn;
use App\Models\OrderItemAddOnValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderAddOnsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $values = OrderItemAddOnValue::where('order_item_id',$this->order_item_id)->where('add_on_id',$this->child_add_on_id)->groupBy("add_on_id")->get();
        $sub_addons = $this->parent_add_on_id != null ? OrderItemAddOn::where('parent_add_on_id',$this->parent_add_on_id)
            ->where('order_item_id',$this->order_item_id)->get() : collect();
        return [
//            'order_id' => $this->order_id,
//            'order_item_id' => $this->order_item_id,
//            'product_id' => $this->product_id,
            'parent_add_on_id' => $this->parent_add_on_id,
            'parent_add_on_name' => $this->parent_add_on_id != null ? AddOn::find($this->parent_add_on_id)->name : null,
            'child_add_on_id' => $this->child_add_on_id,
            'child_add_on_name' => $this->child_add_on_id != null ? AddOn::find($this->child_add_on_id)->name : null,
            'sub_add_ons' => SubAdOnResource::collection($sub_addons->unique('child_add_on_id')),
            'values' => $this->parent_add_on_id == null ? OrderAdOnValueResource::collection($values) : []
        ];
    }
}
