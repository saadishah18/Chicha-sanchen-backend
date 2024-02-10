<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $path = ltrim(request()->path(), '/');
        $lastSegment = basename($path);//        return parent::toArray($request);

        if($lastSegment == 'order-history'){
            $items = $this->orderItems;

        }else{
            $items = $this->orderItems()->latest()->first();
        }
       return [
           'user_id' => $this->user_id,
           'order_id' => $this->id,
           'price' => $this->price,
           'order_date' => $this->order_date,
           'order_date_formated' => Carbon::parse($this->order_date)->toFormattedDateString(),
           'payment_status' => $this->payment_status,
           'orderItems' => $items instanceof \Illuminate\Database\Eloquent\Model
               ? [new OrderItemResource($items)]
               : OrderItemResource::collection($items)
       ];
    }
}
