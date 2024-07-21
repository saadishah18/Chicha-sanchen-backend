<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $actions = view('admin.pages.orders.order-action',['order' => $this])->render();
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'order_date' => $this->order_date,
            'order_unique_id' => $this->order_unique_id,
            'order_date_formatted' => Carbon::parse($this->order_date)->toFormattedDateString(),
            'payment_status' => $this->payment_status,
            'sale_status' => $this->payment_status,
            'orderItemsCount' => $this->orderItems()->count(),
            'full_name' => $this->full_name,
            'actions' => $actions
        ];
    }
}
