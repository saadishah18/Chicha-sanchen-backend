<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\OutletController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('login', [AuthController::class, 'login']);
Route::post('social-login', [AuthController::class, 'social']);
Route::post('register', [AuthController::class, 'register']);
Route::post('resend-otp', [AuthController::class, 'resendOTP']);
//Route::post('phone/verify', [AuthController::class, 'verifyPhone']);
Route::post('forgot-password/send-opt', [AuthController::class, 'sendForgotPasswordOTP']);
Route::post('forgot-password/update-password', [AuthController::class, 'forgotPasswordVerifyOTP']);

//Route::get('/verify-email', [AuthController::class,'verifyEmail'])->name('verify.email');
Route::post('/verify-email', [AuthController::class,'verifyEmail'])->name('verify.email');

Route::get('outlets',[OutletController::class,'index']);
Route::get('outlet-menu',[OutletController::class,'detail']);
Route::get('category-products',[CategoryController::class,'categoryProduct']);

Route::get('outlet-featured-products',[ProductController::class,'featuredProducts']);
Route::get('outlet-featured-products',[ProductController::class,'featuredProducts']);
Route::get('product/{id}/detail',[ProductController::class,'productDetail']);
Route::post('search-product',[ProductController::class,'searchProduct']);
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
////    return $request->user();
//    Route::get('outlets',[OutletController::class,'index']);
//});

Route::prefix('auth')->middleware('auth:sanctum',)->group(function () {
//    return $request->user();
    Route::post('logout', [ProfileController::class, 'logout']);

    Route::post('add-to-cart/{id?}',[\App\Http\Controllers\Api\CartController::class,'addToCart']);
    Route::get('cart-detail',[\App\Http\Controllers\Api\CartController::class,'cartDetail']);
    Route::get('remove-item/{item_id}',[\App\Http\Controllers\Api\CartController::class,'removeCartItem']);
    Route::get('clear-cart',[\App\Http\Controllers\Api\CartController::class,'clearCart']);
    Route::post('place-order',[\App\Http\Controllers\Api\OrderController::class,'placeOrder']);
    Route::get('order-history',[\App\Http\Controllers\Api\OrderController::class,'orderHistory']);
    Route::get('re-order/{order_id}',[\App\Http\Controllers\Api\OrderController::class,'reOrder']);

});
