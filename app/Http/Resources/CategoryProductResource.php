<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $name = $this->name;
// Split the name into words
        $words = explode(' ', $name);
// Remove the first word
        array_shift($words);

        if(count($words) > 1){
            array_shift($words);
        }
// Join the remaining words back into a string
        $name = implode(' ', $words);
        $name = ltrim($name, '+ ');

// Update the original name
        $this->name = $name;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category->name,
            'image' => $this->image != null ? imagePath($this->image) : null,
            'is_featured' => $this->is_featured,
            'in_stock' => $this->in_stock,
            'price' => $this->price
        ];
    }
}
