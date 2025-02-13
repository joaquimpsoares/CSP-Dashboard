<?php



use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('login/microsoft', [LoginController::class, 'redirectToProvider']);
Route::get('login/microsoft/callback', [LoginController::class, 'handleProviderCallback']);
Route::get('login/graph/callback', [LoginController::class, 'handleProviderCallback']);

Route::group(['middleware' => 'auth'], function ()
{

});
// Auth::routes(['register' => false]);
Route::redirect('/', '/home', 301);
Route::get('/home', 'HomeController@index')->name('home');
Route::impersonate();
Auth::routes();
