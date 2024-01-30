<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemAddOn extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function values(){
        return $this->hasMany(OrderItemAddOnValue::class);
    }

}
