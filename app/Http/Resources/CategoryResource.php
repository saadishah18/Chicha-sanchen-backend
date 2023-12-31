<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $totalProducts = 0;
        foreach ($this->children as $child) {
            $totalProducts += $child->products->count();
        }


        return [
            'id' => $this->id,
            'name' => $this->name,
            'child_count' => $this->children_count,
            'sub_cat_total_products' => $totalProducts,
            'image' => '',
            'sub_categories' => CategoryResource::collection($this->children)
        ];
    }
}
