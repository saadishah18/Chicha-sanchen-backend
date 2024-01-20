<?php

namespace App\Http\Resources;

use App\Models\AddOn;
use App\Models\ProductAdOns;
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
            'in_stock' => $this->in_stock,
//            'addOns' => $this->addOns ?$this->transformAddOns($this->addOns) : null,
            'addOns' => [],
        ];
        $get_add_ons = ProductAdOns::where('product_id',$this->id)->get();
        $formatted_add_ons = [];

        foreach ($get_add_ons as $key => $add) {
            if ($add->add_on_parent_id == null) {
                $ad_on_detail = AddOn::find($add->add_on_id);
                $formatted_add_ons[$ad_on_detail->id] = [
                    'add_on_id' => $ad_on_detail->id,
                    'name' => $ad_on_detail->name,
                    'product_id' => $add->product_id,
                    'values' => $ad_on_detail->values,
                    'screen' => $this->screen ?? false,
                    'sub_add_ons' => [], // Initialize sub_add_ons array
                ];
            } else {
                $ad_on_detail = AddOn::find($add->add_on_id);
                $parent_detail = AddOn::find($add->add_on_parent_id);

                // Check if the parent already exists in the array
                if (!isset($formatted_add_ons[$parent_detail->id])) {
                    $formatted_add_ons[$parent_detail->id] = [
                        'add_on_id' => $parent_detail->id,
                        'name' => $parent_detail->name,
                        'product_id' => $add->product_id,
                        'screen' => $this->screen ?? true,
                        'sub_add_ons' => [], // Initialize sub_add_ons array
                    ];
                }

                // Add the sub-add-on details to the parent only if it's not already added
                if (!in_array($ad_on_detail->id, array_column($formatted_add_ons[$parent_detail->id]['sub_add_ons'], 'add_on_id'))) {
                    $formatted_add_ons[$parent_detail->id]['sub_add_ons'][] = [
                        'add_on_id' => $ad_on_detail->id,
                        'name' => $ad_on_detail->name,
                        'product_id' => $add->product_id,
                        'values' => $ad_on_detail->values,
                    ];
                }
            }
        }

// Now $formatted_add_ons contains the unique structure

        $result['addOns'] = $formatted_add_ons;
        return $result;
    }
//
//
//    private function transformAddOns($addOns)
//    {
//        $transformedAddOns = [];
//
//        foreach ($addOns as $addOn) {
//            $add_on_id = $addOn->addOn->id;
//
//            if (!isset($transformedAddOns[$add_on_id])) {
//                $transformedAddOns[$add_on_id] = [
//                    'add_on_id' => $add_on_id,
//                    'name' => $addOn->addOn->name,
//                    'product_id' => $addOn->product_id,
//                    'values' => $this->transformValues($addOn->addOn->values),
////                    'children' => $addOn->children->isEmpty() ? [] : $this->transformAddOns($addOn->children),
//                ];
//            }
//        }
//
//        return array_values($transformedAddOns);
//    }


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
