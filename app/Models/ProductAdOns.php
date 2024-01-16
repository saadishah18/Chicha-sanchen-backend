<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAdOns extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'product_add_ons';

//    public function addon()
//    {
//        return $this->belongsTo(AddOn::class, 'add_on_id');
//    }

    public function value()
    {
        return $this->belongsTo(AddOnValue::class, 'value_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }

    public function addOnValue()
    {
        return $this->belongsTo(AddOnValue::class);
    }

}
