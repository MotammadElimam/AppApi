<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\ProductController;



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });///////


Route::get('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);

Route::middleware('auth:api')->group(function () {

    Route::post('addproduct', [ProductController::class, 'store']);

});

// Route::middleware('auth:api')->group(function () {
//     Route::get('user', 'passport_controller@details');

//     Route::resource('products', 'product_controller');
// });
