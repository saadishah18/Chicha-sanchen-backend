<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
           'product_id' => $this->product_id,
           'product_name' => $this->product ? $this->product->name: '',
//           'product_image' => $this->product->image,
           'product_image' => $this->product && $this->product->image !=null ? imagePath($this->product->image) : null,
           'category_id' => $this->category_id,
           'category_name' => $this->category->name,
           'product_price' => $this->product_price,
           'rewards_type' => $this->rewards_type,
           'addOns' => OrderAddOnsResource::collection($this->orderItemAddOns->unique('child_add_on_id')),
       ];
    }
}
