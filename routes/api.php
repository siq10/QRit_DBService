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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
$uri = "test";
Route::get($uri, function () {
    return response()->json("Laravel sent this baby!");
});



// USERS
Route::resource('users', 'API\UserController')->only([
    'index','show', 'store', 'update', 'destroy'
]);
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');







// PLACES
Route::resource ('places','API\PlacesController')->only(['index','show','store','update','destroy']);


//1
//5 get places, available tables for employer client
//9 get place status



//RATINGS




// TABLES
Route::resource('places.tables','API\PlacesController')->only(['index','show','store','update','destroy']);
//2






Route:: resource ('places.menu','API\PlacesController')->only(['index','show','store','update','destroy']);	
Route:: resource ('places.tables.orders','API\PlacesController')->only(['index','show','store','update','destroy']);	
// Route:: resource ('places.orders','API\PlacesController')->only(['index','show','store','update','destroy']);	


//RESERVATION

Route::resource('reservation','API\ReservationController')-> only(['index','show','store','update','destroy']);
//3 post
//4 put
// Route::resource('reservation.places.tables','API\ReservationController')-> only(['index','show','store','update','destroy']);





//QR-code 

Route::resource('QR','API\QRController')-> only(['index','show','store','update','destroy']);
Route::resource('QR.places.tables','API\QRController')-> only(['index','show','store','update','destroy']);

// Route::resource('QR.places.waiters','API\QRController')-> only(['index','show','store','update','destroy']);
// 6. get
//7 post delete put

// MENU
Route:: resource('menu','API\MenuController')->only(['index','show','store','update','destroy']);




//ORDERS
Route:: resource('orders','API\OrdersController')->only(['index','show','store','update','destroy']);
//4 put order
//change status to order
//11 put waiter id for order
//12 put order status 	
Route:: resource('orders.products','API\OrdersController')->only(['index','show','store','update','destroy']);
//4 post order-product
// $order->attach();

//PRODUCTS
Route:: resource('products','API\ProductsController')->only(['index','show','store','update','destroy']);




//13 waiter/orders ???