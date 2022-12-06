<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
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

Route::group(['middleware' => ['role:Super Admin|Admin|Provider|Reseller|Sub Reseller|Customer']], function () {
    // Route::prefix('azureanalytics')->group(function() {
    //     Route::get('/', 'AzureAnalyticsController@index');
    // });
//Analytics Module Routes Begin
Route::get('/analytics',                                    [\Modules\AzureAnalytics\Http\Livewire\Azure\AzureTable::class, '__invoke'])->name('analytics');
Route::get('/analytics/reports/{subscription}',             [\Modules\AzureAnalytics\Http\Livewire\Azure\AzureReport::class, '__invoke'])->name('analytics.reports');
//Analytics Module Routes finish
    // Route::get('/analytics/reports/{subscription}', [\Modules\AzureAnalytics\Http\Livewire\Azure\AzureReport::class, '__invoke'])->name('analytics.reports');
});


