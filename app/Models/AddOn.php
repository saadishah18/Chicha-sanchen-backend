<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    use HasFactory;

    public function values()
    {
        return $this->hasMany(AddOnValue::class,'add_on_id');
    }

    public function parent()
    {
        return $this->belongsTo(AddOn::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AddOn::class, 'parent_id');
    }

    public function addOnValues()
    {
        return $this->hasMany(AddOnValue::class);
    }
}

