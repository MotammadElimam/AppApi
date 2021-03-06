<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;


Route::post('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);


Route::get('rateavg/{product}', [RatingController::class, 'RateAvg']);
Route::get('TopProductsRating', [RatingController::class, 'TopProductsRatings']);


Route::middleware('auth:api')->group(function () {

Route::post('addOrder',  [OrderController::class, 'store']);
Route::post('cencelOrder/{order}',  [OrderController::class, 'cencelOrder']);
Route::get('ShowBuyerOrders', [OrderController::class, 'ShowBuyerOrders']);
Route::get('ShowBuyeritemsOfOrder', [OrderController::class, 'ShowBuyeritemsOfOrder']);

Route::post('rating/{product}', [RatingController::class, 'ReateProduct']);

Route::prefix('orders')->group(function () {

Route::post('/',  [OrderController::class, 'index']);
//Route::post('destroy/{order}',  [OrderController::class, 'destroy']);
   });
});
