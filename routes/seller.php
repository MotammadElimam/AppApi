<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sellers\PassportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::get('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);


Route::middleware('auth:seller_api')->group(function () {

    Route::post('addproduct', [ProductController::class, 'store']);
    Route::get('getallproducts', [ProductController::class, 'index']);
    Route::post('status', [OrderController::class, 'changeStatus']);


  



});
