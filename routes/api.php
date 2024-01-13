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
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
////    return $request->user();
//    Route::get('outlets',[OutletController::class,'index']);
//});

Route::prefix('auth')->middleware('auth:sanctum',)->group(function () {
//    return $request->user();
});
