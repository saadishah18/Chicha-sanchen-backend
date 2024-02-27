<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartAddOnValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'add_on_id' => $this->add_on_id,
            'id' => $this->value_id,
            'value_name' => $this->value_name,
            'price' => $this->value_price,
        ];
    }
}

