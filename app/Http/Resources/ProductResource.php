<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category->name,
            'image' => '',
            'price' => formatNumber($this->price),
            'size' => [],
            'shots' => [],
            'milk_dairy_alternative' => [],
            'drizzles' => [],
            'additional_sauce' => [],
            'additional_syrup' => [],
            'whipped_cream' => [],
            'allergens' => [],
        ];
    }
}
