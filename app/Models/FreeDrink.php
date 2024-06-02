<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeDrink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'drink_type', 'is_used', 'valid_until'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
