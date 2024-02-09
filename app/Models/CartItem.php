<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

//    protected $with = ['cartProductAddOns'];

    public function cartProductAddOns(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartProductAddOns::class);
    }

    public function cartAddOnValues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartAddOnValue::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function parentAddOnDetail(){
        return $this->belongsTo(AddOn::class,'parent_add_on_id');
    }

    public function childAddOnDetail(){
        return $this->belongsTo(AddOn::class,'child_add_on_id');
    }

//    public function addOnValueDetail(){
//        return $this->belongsTo(AddOn::class,'add_on_value_id');
//    }
}
