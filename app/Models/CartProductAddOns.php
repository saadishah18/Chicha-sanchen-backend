<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProductAddOns extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_add_on_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(self::class, 'child_add_on_id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cartAdOnValues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartAddOnValue::class,'add_on_id');
    }
}
