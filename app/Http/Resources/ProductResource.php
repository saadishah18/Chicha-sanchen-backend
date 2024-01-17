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
        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => strip_tags($this->description),
            'category' => $this->category->name,
            'parent_cat' => $this->category->parent != null ? $this->category->parent->name : null,
            'image' => $this->image !=null ? imagePath($this->image) : null,
            'price' => formatNumber($this->price),
            'is_featured' => $this->is_featured,
//            'addOns' => $this->addOns ? AddOnResource::collection($this->addOns) : null
            'addOns' => $this->addOns ?$this->transformAddOns($this->addOns) : null,
        ];
        return $result;
    }


    private function transformAddOns($addOns)
    {
        $transformedAddOns = [];

        foreach ($addOns as $addOn) {
            $add_on_id = $addOn->addon->id;

            if (!isset($transformedAddOns[$add_on_id])) {
                $transformedAddOns[$add_on_id] = [
                    'add_on_id' => $add_on_id,
                    'name' => $addOn->addon->name,
                    'product_id' => $addOn->product_id,
                    'values' => $this->transformValues($addOn->addon->values),
                ];
            }
        }

        return array_values($transformedAddOns);
    }

    private function transformValues($values)
    {
        $transformedValues = [];

        foreach ($values as $value) {
            $array = [
                'value_id' => $value->id,
                'name' => $value->value,
                'price' => $value->price,
                // Add any other value attributes you need
            ];
            $transformedValues[]  = $array;
        }
        return $transformedValues;
    }
}
