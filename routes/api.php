<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;



Route::get('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);


Route::middleware('auth:api')->group(function () {

Route::post('addOrder',  [OrderController::class, 'store']);
Route::get('getallBuyerorders', [ProductController::class, 'ShowAllBuyerOrders']);


Route::prefix('orders')->group(function () {

Route::post('/',  [OrderController::class, 'index']);
//Route::post('destroy/{order}',  [OrderController::class, 'destroy']);
   });
});
