<?php

namespace App\Http\Resources;

use App\Models\OrderItemAddOnValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubAdOnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $values = OrderItemAddOnValue::where('order_item_id',$this->order_item_id)->where('add_on_id',$this->child_add_on_id)->groupBy("add_on_id")->get();

        return [
          'parent_add_on_id' => $this->parent_add_on_id,
          'child_add_on_id' => $this->child_add_on_id,
          'values' =>OrderAdOnValueResource::collection($values),
        ];
    }
}
