<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;

class Order extends Model
{
    use HasFactory, Billable;

    protected $guarded = ['id'];

    protected $with = ['orderItems'];

    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addPoints()
    {
        DB::transaction(function () {
            if ($this->price >= 18) {
                $points = floor($this->price);
                $this->points = $points;
                $this->save();

                // Schedule to add points to user's total after 60 minutes
                $user = $this->user;
//                $delay = now()->addMinutes(60);
                $delay = now()->addMinutes(1);

                dispatch(function () use ($user, $points) {
                    $loyaltyPoint = LoyaltyPoint::firstOrCreate(['user_id' => $user->id]);
                    $loyaltyPoint->points += $points;
                    $loyaltyPoint->save();

                    // Check if user is eligible for a free drink
                    while ($loyaltyPoint->points >= 350) {
                        FreeDrink::create([
                            'user_id' => $user->id,
                            'drink_type' => 'Loyalty drink', // or specific type if needed
                            'valid_until' => now()->addYear(),
                        ]);

                        // Deduct 350 points
                        $loyaltyPoint->points -= 350;
                        $loyaltyPoint->save();
                    }
                })->delay($delay);
            }
        });
    }

    public function applyFreeDrink($order)
    {
        $freeDrink = FreeDrink::where('user_id', $order->user_id)
            ->where('is_used', 0)
            ->where('valid_until', '>=', now())
            ->first();

        if ($freeDrink) {
            // Logic to mark the free drink as used and apply to the order
            $freeDrink->is_used = 1;
            $freeDrink->save();

            // Optionally apply the free drink to the order
            // For example, reduce the price of the drink from the order
            // or mark a specific item in the order as free
        }
    }
}
