<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\ProductController;



Route::get('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);

Route::middleware('auth:api')->group(function () {

    Route::post('addproduct', [ProductController::class, 'store']);
    Route::get('getallproducts', [ProductController::class, 'index']);


});

