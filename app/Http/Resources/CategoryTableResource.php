<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        if($this->parent == null){
           $parent = 'N/A';
        }else{
            $parent = $this->parent->name;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent' => $parent,
            'image' => '',
            'created_at' => Carbon::parse($this->created_at)->toFormattedDateString(),
        ];
    }
}
