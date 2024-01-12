<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildCategoryResource extends JsonResource
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
//        if($this->id == 18){
//            dd($this, $this->products);
//        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'child_count' => $this->children_count,
            'sub_cat_total_products' => $totalProducts,
            'image' => imagePath($this->image),
            'sub_categories' => ChildCategoryResource::collection($this->children),
            'total_products' => $this->products->count(),
            'products' => $this->products != null ? CategoryProductResource::collection($this->products) : null,
        ];
    }
}
