<?php

namespace App\Http\Resources;

use App\Models\AddOn;
use App\Models\AddOnValue;
use App\Models\CartProductAddOns;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = [
            'cart_item_id' => $this->id,
            'product_id' => $this->product_id,
            'product_name' => $this->product->name,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'product_price' => $this->product_price,
            'addOns' => []
        ];

        $get_add_ons = CartProductAddOns::where('cart_item_id',$this->id)->get();
        $formatted_add_ons = [];

        foreach ($get_add_ons as $key => $add) {
            $value = AddOnValue::find($add->add_on_value_id);
//            dd($value);
            if ($add->parent_add_on_id == null) {
                $ad_on_detail = AddOn::find($add->child_add_on_id);
                $formatted_add_ons[$ad_on_detail->id] = [
                    'add_on_id' => $ad_on_detail->id,
                    'name' => $ad_on_detail->name,
                    'product_id' => $add->product_id,
//                    'value' => new AdOnValueResource($value),
                    'value' => [new AdOnValueResource($value)],
                    'screen' => $this->screen ?? false,
                    'sub_add_ons' => [], // Initialize sub_add_ons array
                ];
            } else {
                $ad_on_detail = AddOn::find($add->child_add_on_id);
                $parent_detail = AddOn::find($add->parent_add_on_id);

                // Check if the parent already exists in the array
                if (!isset($formatted_add_ons[$parent_detail->id])) {
                    $formatted_add_ons[$parent_detail->id] = [
                        'add_on_id' => $parent_detail->id,
                        'name' => $parent_detail->name,
                        'product_id' => $add->product_id,
                        'sub_add_ons' => [], // Initialize sub_add_ons array
                    ];
                }

                // Add the sub-add-on details to the parent only if it's not already added
                if (!in_array($ad_on_detail->id, array_column($formatted_add_ons[$parent_detail->id]['sub_add_ons'], 'add_on_id'))) {

                    $formatted_add_ons[$parent_detail->id]['sub_add_ons'][] = [
                        'add_on_id' => $ad_on_detail->id,
                        'name' => $ad_on_detail->name,
                        'product_id' => $add->product_id,
                        'value' => new AdOnValueResource($value),
                    ];
                }
            }
        }
        $result['addOns'] = $formatted_add_ons;
        return $result;

    }
}
