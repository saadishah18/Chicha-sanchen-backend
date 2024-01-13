<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeaturedProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        dd($this->children->pluck('products')->flatten());
//        CategoryProductResource::collection($this->products)
//        $totalProducts = 0;
//        foreach ($this->children as $child) {
//            $totalProducts += $child->products->count();
//        }
        $featuredProducts = $this->children->pluck('products')->flatten()->filter(function ($product) {
            return $product->is_featured == 1;
        });
        return [
            'id' => $this->id,
            'name' => $this->name,
            'child_count' => $this->children_count,
//            'sub_cat_total_products' => $totalProducts,
            'image' => imagePath($this->image),
            'products' => CategoryProductResource::collection($featuredProducts),
//            'products' => CategoryProductResource::collection($this->children->pluck('products')->flatten()),
        ];
    }
}
