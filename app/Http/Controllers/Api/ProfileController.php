<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\FreeDrink;
use App\Models\LoyaltyPoint;
use App\Repositories\UserRepository;
use App\Service\Facades\Api;

class ProfileController extends Controller
{
    public function get_info(UserRepository $user_repository, $user_id): \Illuminate\Http\JsonResponse
    {
        try {
            return $user_repository->get_one($user_id);
        } catch (\Exception $exception) {
            return Api::server_error($exception);
        }
    }

    public function update(UserRepository $user_repository): \Illuminate\Http\JsonResponse
    {
        try {
            return $user_repository->update(auth()->user());
        } catch (\Exception $exception) {
            return Api::server_error($exception);
        }
    }

    public function logout(){
        $user = auth()->user();
//        $user->device_token = null;
//        $user->update();
        $cart = Cart::where('user_id', $user->id)->first();
        if($cart)
            $cart->delete();
        auth()->user()->tokens()->delete();
        return Api::response(message: trans('User logged out'));
    }

    public function userRewardsDetail(){
        $user = auth()->user();

        // Fetch the total points recorded in the loyalty points table
        $loyaltyPoint = LoyaltyPoint::where('user_id', $user->id)->first();


        // Calculate total earned points till now
//        $totalEarnedPoints = $loyaltyPoint->points + ($loyaltyPoint->points % 350);
        $userTotalFreeDrinkCount = FreeDrink::where('user_id', $user->id)->count();
        $totalEarnedPoints = $loyaltyPoint->points + ($userTotalFreeDrinkCount * 350);

        // Calculate the number of earned drinks
        $totalEarnedDrinks = intdiv($totalEarnedPoints, 350);

        // Calculate remaining points
        $remainingPoints = $loyaltyPoint->points;

        // Fetch the free drinks with their expiry dates
        $availableFreeDrinks = FreeDrink::where('user_id', $user->id)
            ->where('is_used', false)
            ->where('valid_until', '>=', now())
            ->get();

        $usedFreeDrinks = FreeDrink::where('user_id', $user->id)
            ->where('is_used', true)
//            ->where('valid_until', '>=', now())
            ->get();
        $expiredFreeDrinks = FreeDrink::where('user_id', $user->id)
            ->where('is_used', false)
            ->where('valid_until', '<', now())
            ->get();

        // Prepare the response
        $responseData = [
            'total_earned_points' => $totalEarnedPoints,
            'total_earned_drinks' => $totalEarnedDrinks,
            'remaining_points' => $remainingPoints,
            'available_free_drinks' => $availableFreeDrinks->count(),
            'used-free_drinks' => $usedFreeDrinks->count(),
            'expired_free_drinks' => $expiredFreeDrinks->count(),
            'available_drinks_detail' => $availableFreeDrinks
        ];

        return Api::response($responseData,'Reward Points Detail');
    }

}
