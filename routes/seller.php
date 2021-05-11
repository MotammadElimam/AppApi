<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sellers\PassportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::get('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);


Route::get('showAllProducts', [ProductController::class, 'showAllProducts']);
Route::get('ShowCustomProduct/{product}', [ProductController::class, 'ShowCustomProduct']);


Route::get('ShowAllOrders', [OrderController::class, 'showAllOrders']);


Route::middleware('auth:seller_api')->group(function () {


    Route::post('addproduct', [ProductController::class, 'store']);
    Route::put('updateproduct/{product}', [ProductController::class, 'update']);
    Route::delete('deleteproduct/{product}', [ProductController::class, 'destroy']);

    Route::get('getallSellerproducts', [ProductController::class, 'ShowSellerProducts']);


    Route::get('ShowBuyeritemsOfOrder', [OrderController::class, 'ShowBuyeritemsOfOrder']);
    Route::post('changeOrderstatus', [OrderController::class, 'changeStatus']);







});
