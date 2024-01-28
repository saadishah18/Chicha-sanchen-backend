<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['orderItemAddOns'];

    public function orderItemAddOns(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItemAddOn::class);
    }
}
