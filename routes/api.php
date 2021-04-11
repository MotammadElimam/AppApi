<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;



Route::get('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);

Route::middleware('auth:api')->group(function () {
   Route::get('getallproducts', [ProductController::class, 'index']);
  
  // Route::resource('orders', OrderController::class)->except(['create', 'edit', 'update']);
   Route::prefix('orders')->group(function () {
       Route::post('/',  [OrderController::class, 'index']);
       Route::post('store',  [OrderController::class, 'store']);
       Route::post('destroy/{order}',  [OrderController::class, 'destroy']);
   });
    //Route::get('Cart/${id}', [CartController::class, 'addToCart']);
});

