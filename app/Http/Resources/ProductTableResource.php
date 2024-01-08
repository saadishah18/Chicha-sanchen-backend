<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $actions = view('admin.pages.products.actions',['product' => $this])->render();
        $image = imagePath($this->image);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->name,
            'category' => $this->category->name,
            'parent_category' => $this->category->parent->name,
            'image' => $this->image !=null ? "<img src='$image' alt='p_image' width='100px' height='100px'>" : null,
            'price' => formatNumber($this->price),
            'featured' => $this->is_featured == 1 ? 'Yes' : 'No',
            'active' => $this->is_active == 1 ? 'Active' : 'In-active',
            'actions' => $actions,
        ];

    }
}
