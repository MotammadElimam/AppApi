<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('testrate', function () {
    $product = App\Models\Product::whereHas('ratings')->with('avgRating');

    return  $product->get();
});

Route::get('/', function () {
    return view('welcome');
});

Route:: get('passport-client', function () {
     if(! defined('STDIN')) define('STDIN', fopen("php://stdin","r"));
    //  Artisan::call('passport:install');
    //  Artisan::call('passport:client --personal');
     Artisan::call('storage:link');
     

    return Artisan::output();
});
