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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');


});
Route::get('check', 'AuthController@isLoggedIn');
Route::post('/hotels/image/{hotel}', 'HotelController@image');
Route::post('/rooms/image/{room}', 'RoomController@image');
Route::resource('/hotels', 'HotelController');
Route::resource('/rooms', 'RoomController');
Route::resource('/roomtypes', 'RoomTypeController');
Route::resource('/prices', 'PriceController');
Route::resource('/bookings', 'BookingController');
