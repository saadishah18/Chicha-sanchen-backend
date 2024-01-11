<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnValue extends Model
{
    use HasFactory;
    protected $table = 'add_ons_values';
    protected $guarded = ['id'];
}
