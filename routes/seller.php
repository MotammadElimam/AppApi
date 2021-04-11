<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sellers\PassportController;

Route::get('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);


Route::middleware('auth:seller_api')->group(function () {

    Route::post('addproduct', [ProductController::class, 'store']);
    Route::get('getallproducts', [ProductController::class, 'index']);
    //Route::get('Cart/${id}', [CartController::class, 'addToCart']);


    Route::get('sellers', function()  {




        return "ok";
     });
     



});



