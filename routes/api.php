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
    // Route::post('/login', [AuthController::class, 'login']);
    // Route::post('/register', [AuthController::class, 'register']);
    // Route::post('/logout', [AuthController::class, 'logout']);
    // Route::post('/refresh', [AuthController::class, 'refresh']);
    // Route::get('/user-profile', [AuthController::class, 'userProfile']);
    // Route::get('createNewToken', [AuthController::class, 'createNewToken']);

    #Customers Routes
    Route::get('customers', 'CustomerController@index');
    Route::get('customers/{customer}', 'CustomerController@show');
    Route::post('customers', 'CustomerController@store');

    #Resellers Routes
    Route::get('resellers', 'ResellerController@index');

    #Subscriptions Routes
    Route::get('subscriptions', 'SubscriptionsController@index');
});

