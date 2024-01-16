<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddOnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->addon->id,
            'name' => $this->addon->name, // Replace with your actual add-on attribute
            'product_id' => $this->product_id,
            'values' => AdOnValueResource::collection($this->whenLoaded('values')),
        ];
    }
}
