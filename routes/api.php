<?php

use App\Customer;
use Illuminate\Http\Request;
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
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('customers', 'CustomerController@index');
});


// Route::group([
//     'middleware' => 'auth:sanctum',
//     // 'prefix' => 'auth'

// ], function ($router) {
//     Route::get('customers', 'CustomerController@index');

//     Route::post('/login', [AuthController::class, 'login']);
//     Route::post('/register', [AuthController::class, 'register']);
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::post('/refresh', [AuthController::class, 'refresh']);
//     Route::get('/user-profile', [AuthController::class, 'userProfile']);
// });


// Route::group([
//     'middleware' => 'auth:api',
//     'prefix' => 'customer'

// ], function ($router) {

//     Route::get('customers', 'CustomerController@index');
//     Route::get('customers/{customer}', 'CustomerController@show');
//     Route::post('customers', 'CustomerController@store');
// });

// Route::group([
//     'middleware' => 'auth:api',
//     'prefix' => 'reseller'

// ], function ($router) {

//     Route::get('resellers', 'ResellerController@index');
// });

// Route::group([
//     'middleware' => 'auth:api',
//     'prefix' => 'subscription'

// ], function ($router) {

//     Route::get('subscriptions', 'SubscriptionsController@index');
// });

