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

Route::post('users','API\UsersController@store');

Route::group(['middleware' => 'authorization'], function () {
    Route:: resource('orders','API\OrdersController')->only(['index','show','store','update','destroy']);

    Route:: resource('clients','API\ClientsController')->only(['index','show','store','update','destroy']);

    Route:: resource('waiters','API\WaitersController')->only(['index','show','store','update','destroy']);

    Route:: resource('owners','API\OwnersController')->only(['index','show','store','update','destroy']);

    Route::resource('users', 'API\UsersController')->only(['index','show', 'update', 'destroy']);

    Route::resource ('places','API\PlacesController')->only(['index','show','store','update','destroy']);

    Route::resource('reservation','API\ReservationsController')-> only(['index','show','store','update','destroy']);

    Route:: resource('orders.products','API\Orders\ProductsController')->only(['index','show','store','update','destroy']);

    Route:: resource('products','API\ProductsController')->only(['index','show','store','update','destroy']);
});
// USERS

//------------------------------------------------------ hmm

Route::resource('authentication', 'API\AuthenticationsController')->only(['show','store','update','destroy']);
Route::resource('authorization', 'API\AuthorizationsController')->only(['show','store','update','destroy']);

