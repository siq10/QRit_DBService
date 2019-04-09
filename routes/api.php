<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$uri = "test";
Route::get($uri, function () {
    return response()->json("Laravel sent this baby!");
})->middleware('authorization');


Route::middleware(['authorization'])->group(function () {
    Route:: resource('orders','API\OrdersController')->only(['index','show','store','update','destroy']);

    Route:: resource('clients','API\ClientsController')->only(['index','show','store','update','destroy']);

    Route:: resource('waiters','API\WaitersController')->only(['index','show','store','update','destroy']);

    Route:: resource('owners','API\OwnersController')->only(['index','show','store','update','destroy']);

    Route::resource('users', 'API\UserController')->only(['index','show', 'store', 'update', 'destroy']);

    Route::resource ('places','API\PlacesController')->only(['index','show','store','update','destroy']);

    Route::resource('reservation','API\ReservationController')-> only(['index','show','store','update','destroy']);

    Route:: resource('orders.products','API\Orders\ProductsController')->only(['index','show','store','update','destroy']);

    Route:: resource('products','API\ProductsController')->only(['index','show','store','update','destroy']);
});
// USERS
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
