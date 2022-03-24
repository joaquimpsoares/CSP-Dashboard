<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    /*
    |--------------------------------------------------------------------------
    | API Resellers
    |--------------------------------------------------------------------------
    */
    Route::get('resellers', 'ResellerController@index');

    /*
    |--------------------------------------------------------------------------
    | API Customers
    |--------------------------------------------------------------------------
    */
    Route::get('customers', 'CustomerController@index');
    Route::get('customers/{customer}', 'CustomerController@show');
    Route::get('customers/{customer}/subscriptions', 'CustomerController@customerSubscription');
    Route::get('customers/{customer}/subscriptions/{subscription}', 'CustomerController@customerSubscriptionID');
    Route::post('customers', 'CustomerController@store');
    
    /*
    |--------------------------------------------------------------------------
    | API Subscriptions
    |--------------------------------------------------------------------------
    */
    Route::get('subscriptions', 'SubscriptionsController@index');
    Route::get('subscriptions/{subscription}', 'SubscriptionsController@show');
    Route::post('subscriptions/{subscription}/update/', 'SubscriptionsController@update');
    
    Route::get('createNewToken', [AuthController::class, 'createNewToken']);
});
