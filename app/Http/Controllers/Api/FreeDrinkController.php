<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FreeDrink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreeDrinkController extends Controller
{
    public function getFreeDrinks()
    {
        $user = Auth::user();
        $freeDrinks = FreeDrink::where('user_id', $user->id)
            ->where('is_used', false)
            ->where('valid_until', '>=', now())
            ->get();

        return response()->json($freeDrinks);
    }
}
