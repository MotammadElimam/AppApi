<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sellers\PassportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::get('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);
//Route::get('getallproducts', [ProductController::class, 'showAllProducts']);

Route::middleware('auth:seller_api')->group(function () {

    Route::post('addproduct', [ProductController::class, 'store']);
    Route::delete('deleteproduct/{product}', [ProductController::class, 'destroy']);
    Route::get('getallSellerproducts', [ProductController::class, 'index']);

    Route::post('changeOrderstatus', [OrderController::class, 'changeStatus']);







});
