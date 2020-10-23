<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('products', 'ProductController');
Route::apiResource('customers', 'CustomerController');
Route::apiResource('orders', 'OrderController');
Route::apiResource('neworder', 'ApiController');
Route::post('uploadcsv', 'UploadCsvController@fileImport');
Route::get('customers/first_name/{first_name}','CustomerController@getFirst_name');
Route::get('getAllOrders','OrderController@getAllOrders');
