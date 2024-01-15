<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAdOns extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'product_add_ons';
}
