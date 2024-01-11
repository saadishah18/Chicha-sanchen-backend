<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdOnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $actions = view('admin.pages.adOns.actions',['adOne' => $this])->render();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'actions' => $actions,
        ];
    }
}
