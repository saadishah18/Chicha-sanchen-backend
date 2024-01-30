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
           'product_name' => $this->product->name,
           'product_image' => $this->product->image,
           'category_id' => $this->category_id,
           'category_name' => $this->category->name,
           'product_price' => $this->product_price,
           'addOns' => OrderAddOnsResource::collection($this->orderItemAddOns),
       ];
    }
}
