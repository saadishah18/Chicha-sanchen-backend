<?php

namespace App\Models;

use App\Developer\Traits\HasImageUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Developer\Traits\HasAttachment;
//use App\Developer\Traits\HasVideoUrl;
class Product extends Model
{
    use HasFactory;
    use HasAttachment, HasImageUpload;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function outlets()
    {
        return $this->belongsToMany(Outlet::class, 'product_outlets');
    }

    public function addOns()
    {
        return $this->hasMany(ProductAdOns::class);
    }

    public function assgiendParentAddOns()
    {
        return $this->hasMany(ProductAdOns::class,'add_on_parent_id');
    }

    public function addOnsNew()
    {
        return $this->belongsToMany(AddOn::class, 'product_add_ons')
            ->withPivot('value_id'); // Assuming you have a value_id column in your pivot table
    }
}
