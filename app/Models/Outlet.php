<?php

namespace App\Models;

use App\Service\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope());
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_outlets');
    }

    public function categories()
    {
        return $this->hasManyThrough(Category::class, Product::class,'category_id','id','id','id');
    }
}
